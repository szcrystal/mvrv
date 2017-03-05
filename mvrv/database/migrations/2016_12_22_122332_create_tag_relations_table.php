<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('atcl_id');
            $table->integer('tag_id');
            //$table->string('tag_name');
            $table->timestamps();
            
            $table->index('atcl_id');
            $table->index('tag_id');
        });
        
        
//        $n = 0;
//        while($n < 5) {
//            DB::table('tag_relations')->insert([
//                    'user_id' => 1,
//                    'base_id' => 5,
//                    
//                    'created_at' => date('Y-m-n H:i:s', time()),
//                    'updated_at' => date('Y-m-n H:i:s', time()),
//                ]
//            );
//            
//            $n++;
//        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_relations');
    }
}
