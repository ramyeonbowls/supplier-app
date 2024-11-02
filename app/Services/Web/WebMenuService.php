<?php

namespace App\Services\Web;

use App\Repositories\Web\WebMenuRepository;

class WebMenuService 
{
	protected $webMenuRepo;

	public function __construct(WebMenuRepository $webMenuRepo)
	{
		$this->webMenuRepo = $webMenuRepo;
	}

	public function getAccessControlList($username)
	{
		return $this->webMenuRepo->getAccessControlList($username)
			->map(function ($value) use ($username) {
				return $this->formatNavbar($username, $value);
			});
	}

	public function formatNavbar($username, $value)
	{
		$childs = $this->webMenuRepo->getAccessControlList($username, $value->id)
			->map(function ($value) use ($username) {
				return $this->formatNavbar($username, $value);
			})->toArray();

		return [
			'previd' => $value->previd,
			'menu_fn' => $value->menu_fn,
			'menu_link' => $value->menu_link,
			'menu_label' => $value->menu_label,
			'menu_desc' => $value->menu_desc,
			'menu_icon' => $value->menu_icon,
			'childs' => $childs
		];
	}
}