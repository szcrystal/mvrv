<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_bases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id');
            $table->boolean('del_status');
            
            
            $table->string('category')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->string('movie_site')->nullable()->default(NULL);
            $table->string('movie_url')->nullable()->default(NULL);
            
            $table->string('sumbnail')->nullable()->default(NULL);
            $table->string('sumbnail_url')->nullable()->default(NULL);

            
            $table->integer('view_count')->nullable()->default(NULL);
            
            $table->date('up_date')->nullable()->default(NULL);
                       
            $table->timestamps();
        });
        
        $n = 0;
        while($n < 5) {
            DB::table('article_bases')->insert([
                    'owner_id' => 0,
                    'post_id' => ($n+1),
                    'del_status' => 0,
                    'up_date' => '2017-03-03',
                    'category' => 'スポーツ',
                    'title' => 'スポーツの動画	',
                    'sumbnail' => '/images/abc.jpg',
                    'sumbnail_url' => 'http://example.com',
                    'tag_1' => '1,4,7,10',
                    'tag_2' => '2,5,8',
                    'tag_3' => '',
                    'movie_site' => 'youtube',
                    'movie_url' => 'https://www.youtube.com/watch?v=8wWZs3WQyF4',
                    'view_count' => 3+$n,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
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
        Schema::dropIfExists('article_bases');
    }
}
