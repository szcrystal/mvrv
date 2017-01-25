<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id');
            $table->boolean('del_status');
            
            $table->integer('cate_id');
            $table->string('title');
            $table->string('movie_site');
            $table->string('movie_url');
            
            $table->string('thumbnail')->nullable()->default(NULL);
            $table->string('thumbnail_org')->nullable()->default(NULL);
            //$table->text('content')->nullable()->default(NULL);
            
            $table->boolean('open_status');
            $table->boolean('open_history');
            $table->timestamp('open_date')->nullable()->default(NULL);
            $table->integer('view_count');
            
            $table->timestamps();
        });
        
        $n = 0;
        while($n < 5) {
            DB::table('articles')->insert([
                    'owner_id' => 0,
                    'del_status' => 0,
                    
                    'cate_id' => 1,
                    'title' => '【メッシ 神業ドリブルが炸裂！】バルセロナ vs エスパニョール 4-1 全ゴールハイライト',
                    'movie_site' => 'youtube',
                    'movie_url' => 'https://www.youtube.com/watch?v=8wWZs3WQyF4',
//                    'tag_1' => 'タグ1-A,タグ1-C',
//                    'tag_2' => 'タグ2-B',
//                    'tag_3' => 'タグ3-B,タグ3-C',
					'thumbnail' => '',
                    'thumbnail_org' => '',
                    //'content' => "すると、バルセロナの背番号10が立て続けに切れ味鋭いドリブルからゴールを演出する。後半22分、イニエスタが相手数人に囲まれながらもメッシにつなぐと、メッシが狭いエリアで細かいタッチを駆使して4人を抜き去って左足シュート。ヒメネスが弾いたボールに反応したL・スアレスがきっちり蹴り込み、リードを2点差に広げた。さらに直後の同24分にはドリブル突破を仕掛けたメッシが一気にスピードアップして再び相手4人を置き去りにすると、こぼれたボールをDFジョルディ・アルバが流し込んで3点目が生まれた。\n後半34分にDFダビド・ロペスに決められてエスパニョールに1点を返されたバルセロナだが、同45分にL・スアレスとのパス交換からPA内に進入したメッシがダイレクトで合わせてネットを揺らし、4-1の快勝を収めた。\nご視聴いただき、ありがとうございます。\nチャンネル登録、コメント＆高評価をいただけると嬉しいです♪\nチャンネル登録はこちら\nhttps://www.youtube.com/channel/UCMFR...\n【引用元】Livedoor NEWS",
                   	
                    'open_status' => 0,
                    'open_history' => 0,
                    'open_date' => '2017-01-10 11:11:11',
                    'view_count' => $n+3,
                    
                    
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
        Schema::dropIfExists('articles');
    }
}
