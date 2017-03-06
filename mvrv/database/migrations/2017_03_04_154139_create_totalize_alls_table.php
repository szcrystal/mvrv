<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTotalizeAllsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('totalize_alls', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('atcl_id');
            $table->integer('total_count')->default(0);
            
            $table->timestamps();
            
            $table->index('atcl_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('totalize_alls');
    }
}
