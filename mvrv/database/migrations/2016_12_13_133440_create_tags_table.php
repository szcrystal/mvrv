<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->string('name');
            $table->string('slug')->unique()->nullable()->default(NULL);
            $table->integer('view_count')->nullable()->default(NULL);
            $table->timestamps();
        });
        
        $n = 0;
        while($n < 5) {
            DB::table('tags')->insert([
            		'group_id' => 1,
                    'name' => 'りんご_'.$n,
                    'slug' => 'apple-'.$n,
                    'view_count' => $n+5,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
            DB::table('tags')->insert([
            		'group_id' => 2,
                    'name' => 'みかん_'.$n,
                    'slug' => 'orange-'.$n,
                    'view_count' => $n+5,
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
            DB::table('tags')->insert([
            		'group_id' => 3,
                    'name' => 'ぶどう_'.$n,
                    'slug' => 'grape-'.$n,
                    'view_count' => $n+5,
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
        Schema::dropIfExists('tags');
    }
}
