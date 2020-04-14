<?php

namespace App\Models;

use App\Services\BaseModel;

class Comment extends BaseModel
{
    public $columns = [
        ['name' => 'user_id'],
        ['name' => 'content'],
        ['name' => 'activated'],
        ['name' => 'image_gallery'],
        ['name' => 'video_gallery'],
        [
            'name' => 'commentable_type',
            'type' => 'string',
            'database' => 'nullable',
            'rule' => '',
            'help' => '',
            'form_type' => '',
            'table' => true,
        ],
        [
            'name' => 'commentable_id',
            'type' => 'unsignedBigIntiger',
            'database' => 'nullable',
            'rule' => '',
            'help' => '',
            'form_type' => '',
            'table' => true,
        ],
    ];

    public function commentable()
    {
        return $this->morphTo();
    }
}
