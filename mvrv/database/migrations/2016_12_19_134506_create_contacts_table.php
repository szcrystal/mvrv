<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('category')->nullable()->default(NULL);
            $table->string('name')->nullable()->default(NULL);
            $table->string('email')->nullable()->default(NULL);
            $table->text('context')->nullable()->default(NULL);
            $table->boolean('done_status');

            $table->timestamps();
        });
        
        $n = 0;
        while($n < 5) {
            DB::table('contacts')->insert([
                    'category' => 'お問合わせ',
                    'name' => 'あいうえお',
                    'email' => 'bonjour@frank.fam.cx',
                    'context' => 'あいうえおかきくけこさしすせそ',
                    'done_status' => 0,

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
        Schema::dropIfExists('contacts');
    }
}
