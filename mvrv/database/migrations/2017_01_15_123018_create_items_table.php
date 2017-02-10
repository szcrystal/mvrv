<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('atcl_id');
            $table->string('item_type');
            $table->string('main_title')->nullable()->default(NULL);
            $table->integer('title_option')->nullable()->default(NULL);
            
            $table->longText('main_text')->nullable()->default(NULL);
            
            $table->string('image_path')->nullable()->default(NULL);
            $table->string('image_title')->nullable()->default(NULL);
            $table->string('image_orgurl')->nullable()->default(NULL);
            $table->string('image_comment')->nullable()->default(NULL);
            
            $table->string('link_title')->nullable()->default(NULL);
            $table->string('link_url')->nullable()->default(NULL);
            $table->string('link_imgurl')->nullable()->default(NULL);
            $table->integer('link_option')->nullable()->default(NULL);
            
            $table->integer('item_sequence')->nullable()->default(NULL);
            
            $table->boolean('delete_key')->default(0);
            
//            $table->string('sumbnail')->nullable()->default(NULL);
//            $table->string('sumbnail_org')->nullable()->default(NULL);
//            $table->text('content')->nullable()->default(NULL);
//            
//            $table->boolean('open_history');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
