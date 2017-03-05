<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTotalizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('totalizes', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('atcl_id');
            $table->date('view_date');
            $table->timestamp('view_last');
            $table->integer('view_count')->default(0);
            
            $table->timestamps();
            
            $table->index('atcl_id');
            $table->index('view_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('totalizes');
    }
}
