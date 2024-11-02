<?php

namespace App\Repositories\Web;

use App\Models\Web\WebMenu;
use App\Models\Web\WebMenuAcl;

class WebMenuRepository 
{
	public function getAll()
	{
		return WebMenu::sharedLock()->get();
	}

	public function getVisibleOnly()
	{
		return WebMenu::sharedLock()
			->where('menu_visible', 1)
			->get();
	}

	public function getAccessControlList($username, $parent = 0)
	{
		return WebMenu::select(
				'id',
				'previd',
				'menu_fn',
				'menu_link',
				'menu_label',
				'menu_desc',
				'menu_seq',
				'menu_icon'
			)
			->sharedLock()
			->where('menu_visible', 1)
			->where('previd', $parent)
			->whereIn('id', 
				WebMenuAcl::sharedLock()
					->select('menu_id')
					->where('username', $username)
			)
			->orderBy('menu_seq', 'ASC')
			->get();
	}

	public function findWebMenuByParentId($parentId)
    {
        return WebMenu::select(
                'id',
                'previd',
                'menu_fn',
                'menu_link',
                'menu_label',
                'menu_desc',
                'menu_seq',
                'permission',
                'menu_icon'
            )
            ->sharedLock()
            ->where('menu_visible', 1)
            ->where('previd', $parentId)
            ->orderBy('menu_seq', 'ASC')
            ->get();
    }
}