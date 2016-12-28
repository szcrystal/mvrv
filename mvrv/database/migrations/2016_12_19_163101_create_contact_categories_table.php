<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');
            $table->timestamps();
        });
        
        
        DB::table('contact_categories')->insert([
                'category' => 'お問合わせ',

                'created_at' => date('Y-m-n H:i:s', time()),
                'updated_at' => date('Y-m-n H:i:s', time()),
            ]
        );
        
        DB::table('contact_categories')->insert([
                'category' => '削除依頼',

                'created_at' => date('Y-m-n H:i:s', time()),
                'updated_at' => date('Y-m-n H:i:s', time()),
            ]
        );
        
        DB::table('contact_categories')->insert([
                'category' => 'その他',

                'created_at' => date('Y-m-n H:i:s', time()),
                'updated_at' => date('Y-m-n H:i:s', time()),
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
        Schema::dropIfExists('contact_categories');
    }
}
