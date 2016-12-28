<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('base_id');
            
            $table->string('title')->nullable()->default(NULL);
            $table->string('sub_title')->nullable()->default(NULL);
            $table->text('text')->nullable()->default(NULL);
            
            $table->string('image_title')->nullable()->default(NULL);
            $table->string('image_path')->nullable()->default(NULL);
            $table->string('image_url')->nullable()->default(NULL);
            $table->text('image_comment')->nullable()->default(NULL);
            
            $table->string('link_title')->nullable()->default(NULL);
            $table->string('link_url')->nullable()->default(NULL);
            $table->string('link_image_url')->nullable()->default(NULL);
            $table->string('link_option')->nullable()->default(NULL);
            
            $table->boolean('open_status');
            $table->timestamp('open_date')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        $n = 0;
        while($n < 5) {
            DB::table('article_posts')->insert([
                    'user_id' => 1,
                    'base_id' => 5,
                    
                    'title' => 'サッカーの試合決勝戦',
                    'sub_title' => 'ドイツ対オランダ',
                    'text' => 'ドイツ対オランダのテキストドイツ対オランダのテキストドイツ対オランダのテキスト',
                    'image_title' => 'サッカーの画像',
                    'image_path' => '/images/soccer.png',
                    'image_url' => 'http://example.com',
                    'image_comment' => '画像のコメントコメント',
                    'link_title' => 'これを見る',
                    'link_url' => '/article/single/',
                    'link_image_url' => 'http://192.168.10.10/images/abc.png',
                    'link_option' => 'タイプB',
					
                    'open_status' => 1,
                    //'open_date' => 0000-00-00 00:00:00,
                    
                    'created_at' => date('Y-m-n H:i:s', time()),
                    'updated_at' => date('Y-m-n H:i:s', time()),
                ]
            );
            
            $n++;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_posts');
    }
}
