<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixes', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('not_open');
            $table->string('title');
            $table->string('sub_title')->nullable()->default(NULL);
            $table->string('slug');
            $table->text('contents')->nullable()->default(NULL);

            $table->timestamps();
        });
        
        DB::table('fixes')->insert([
                    'not_open' => 0,
                    
                    'title' => '会社概要',
                    'sub_title' => 'COMPANY',
                    'slug' => 'company',

					'contents' => "<h4>会社概要と詳細について</h4>\n<ul>\n<li>aaaaa</li><li>bbbbb</li><li>ccccc</li>\n</ul>\n",
                    
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
        Schema::dropIfExists('fixes');
    }
}
