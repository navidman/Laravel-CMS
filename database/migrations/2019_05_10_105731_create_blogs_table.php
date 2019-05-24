<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogsTable extends Migration
{
    public $table_name = 'blogs';
    public $columns = [
        [
            'name' => 'title', 
            'type' => 'string',
            'rule' => 'unique',
        ],
        [
            'name' => 'url', 
            'type' => 'string',
            'rule' => 'unique',
        ],
        [
            'name' => 'short_content', 
            'type' => 'string',
            'rule' => 'nullable',
        ],
        [
            'name' => 'content', 
            'type' => 'text',
        ],
        [
            'name' => 'meta_description', 
            'type' => 'string',
        ],
        [
            'name' => 'keywords', 
            'type' => 'string',
            'rule' => 'nullable',
        ],
        [
            'name' => 'meta_image', 
            'type' => 'string',
            'rule' => 'nullable',
        ],
        [
            'name' => 'published', 
            'type' => 'boolean',
            'rule' => 'default',
        ],
        [
            'name' => 'google_index', 
            'type' => 'boolean',
            'rule' => 'default',
        ],
        [
            'name' => 'canonical_url', 
            'type' => 'string',
            'rule' => 'nullable',
        ],
        [
            'name' => 'creator_id', 
            'relation' => 'users',
        ],
        [
            'name' => 'editor_id', 
            'relation' => 'users',
        ],
    ];
    /**
     * Run the migrations.
     */
    public function up()
    {
        $columns = $this->columns;
        Schema::create($this->table_name, function (Blueprint $table) use ($columns) {
            $table->bigIncrements('id');
            foreach($columns as $column){
                $name = $column['name'];
                $type = isset($column['type']) ? $column['type'] : '';
                $rule = isset($column['rule']) ? $column['rule'] : '';
                $relation = isset($column['relation']) ? $column['relation'] : '';

                if($relation){
                    $table->unsignedBigInteger($name);
                    $table->foreign($name)->references('id')->on($relation);
                }
                else{
                    $table->{$type}($name)->{$rule}(true);
                }
            }
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::create('blogs', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('url')->unique();
        //     $table->string('title')->unique();
        //     $table->string('short_content')->nullable();
        //     $table->text('content');
        //     $table->string('meta_description');
        //     $table->string('keywords')->nullable();
        //     $table->string('meta_image')->nullable();
        //     $table->boolean('published')->default(true);
        //     $table->boolean('google_index')->default(true);
        //     $table->string('canonical_url')->nullable();
        //     // $table->string('related_blogs')->nullable();
        //     // $table->integer('category_id')->unsigned();
        //     // $table->foreign('category_id')->references('id')->on('categories');
        //     $table->integer('creator_id')->unsigned();
        //     $table->foreign('creator_id')->references('id')->on('users');
        //     $table->integer('editor_id')->unsigned();
        //     $table->foreign('editor_id')->references('id')->on('users');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
