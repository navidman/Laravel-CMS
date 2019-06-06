<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Base\BaseAdminController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

class SettingController extends BaseAdminController
{
	public $model = 'SettingGeneral';
	
	public function getLog()
	{
        $this->meta['title'] = __('Log Manager');
        $this->meta['alert'] = 'Log of system with all traces!';

		return view('admin.setting.log', ['meta' => $this->meta]);
	}

	public function getLogView(LogViewerController $LogViewerController)
	{
		return $LogViewerController->index();
	}

	public function getApi()
	{
        $this->meta['title'] = __('API Manager');

		return view('admin.setting.api', ['meta' => $this->meta]);
	}

	public function getAdvance()
	{
		return view('admin.setting.advance');
	}
}
