<?php

namespace App\Policies;

use App\Services\BasePolicy;

class AnnouncePolicy extends BasePolicy
{
	public $model_slug = 'announce';
}