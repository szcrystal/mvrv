<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique()->nullable()->default(NULL);
			$table->boolean('open_status');
            
            $table->timestamps();
        });
        
        DB::table('tag_groups')->insert([
                    'name' => 'キーワード',
                    'slug' => 'keyword',
                    'open_status' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('tag_groups')->insert([
                    'name' => '俳優',
                    'slug' => 'actor',
                    'open_status' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('tag_groups')->insert([
                    'name' => 'スタッフ',
                    'slug' => 'staff',
                    'open_status' => 1,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_groups');
    }
}
