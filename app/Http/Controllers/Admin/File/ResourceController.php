<?php

namespace App\Http\Controllers\Admin\File;

use App\Services\BaseResourceController;

class ResourceController extends BaseResourceController
{
    public $model_slug = 'file';

    public function removeBySrc()
    {
		$src = $this->request->input('src');
		$file = $this->model_repository->where('src', $src)->first();
		$file_model_namespace = $file->fileable_type;
		$this->authorize('index', $file_model_namespace);
		$this->destroy($file->id);

		return response()->json([
            'data' => ['message' => __('File deleted successfully!')],
        ]);
    }
}
