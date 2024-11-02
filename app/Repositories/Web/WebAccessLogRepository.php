<?php

namespace App\Repositories\Web;

use App\Models\Web\WebMenu;
use App\Models\Web\WebMenuAcl;
use App\Models\Web\WebAccessLog;
use Illuminate\Support\Facades\DB;

class WebAccessLogRepository 
{
	public function get($filter = [])
	{
		return WebAccessLog::sharedLock()
			->when(isset($filter['uid']), function($query) use ($filter) {
				$query->where('access_uid', $filter['uid']);
			})
			->get();
	}

	public function updateLeaveDate()
	{
		$max_accessid = WebAccessLog::where('method', 'GET')
			->where('access_uid', auth()->user()->email)
			->max('id');

		return DB::transaction(function() use ($max_accessid) {
				WebAccessLog::where('id', $max_accessid)
					->update([
						'leave_date' => now()->toDateTimeString()
					]);
			});
	}

	public function createAccessLog($data)
	{
		return DB::transaction(function() use ($data) {
			$menu = WebMenu::where('menu_fn', $data['name'])->first();
			$qstring = explode('?', $data['full_url']);
			$qstring = (count($qstring) < 2) ? 'menu_fn='. $data['name'] : ((strpos($qstring[1],"menu_fn") === false) ? 'menu_fn='. $data['name'] .'&'. $qstring[1] : $qstring[1]);
			
			$accessLog = new WebAccessLog;
			$accessLog->access_mid      = $menu->id;
			$accessLog->access_url      = url($data['url']);
			$accessLog->access_qstring  = $qstring;
			$accessLog->access_ip       = $data['access_ip'];
			$accessLog->access_uid      = auth()->user()->email;
			$accessLog->save();

			return $accessLog->fresh();
		});
	}

	public function getAclPermission($menuId)
	{
		$web_menu = WebMenu::select([
			'id',
			'menu_fn',
			'menu_label',
			'menu_desc'
		])
		->where('menu_visible', 1)
		->where('menu_fn', $menuId)
		->whereIn('id', WebMenuAcl::sharedLock()->select('menu_id')->where('username', auth()->user()->email));

		if($web_menu->count()) {
			$web_menu = $web_menu->first();
			$permission = WebMenuAcl::sharedLock()
				->where('username', auth()->user()->email)
				->where('menu_id', $web_menu->id)
				->first();

			return [
				'menu_fn' => $web_menu->menu_fn,
				'menu_label' => $web_menu->menu_label,
				'menu_desc' => $web_menu->menu_desc,
				'permission' => [
					'create' => (boolean) $permission->create_permission,
					'read' => (boolean) $permission->read_permission,
					'update' => (boolean) $permission->update_permission,
					'delete' => (boolean) $permission->delete_permission
				]
			];
		}
		return null;
	}
}