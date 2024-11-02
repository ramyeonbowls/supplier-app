<?php

namespace App\Services\Web;

use App\Repositories\Web\WebAccessLogRepository;

class WebAccessLogService 
{
	protected $webAccessLogRepo;

	public function __construct(WebAccessLogRepository $webAccessLogRepo)
	{
		$this->webAccessLogRepo = $webAccessLogRepo;
	}

	public function createAccessLog($data)
	{
		$data['access_ip'] = $data->getClientIp();

		// Noted leave date
		$this->webAccessLogRepo->updateLeaveDate();
		// End noted leave date

		return $this->webAccessLogRepo->createAccessLog($data);
	}

	public function getAclPermission($menuId)
	{
		return $this->webAccessLogRepo->getAclPermission($menuId);
	}
}