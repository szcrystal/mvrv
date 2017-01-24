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
            $table->string('ask_category');
            $table->integer('delete_id')->nullable()->default(NULL);
            $table->string('user_name');
            $table->string('user_email');
            $table->text('context')->nullable()->default(NULL);
            $table->boolean('done_status');

            $table->timestamps();
        });
        
        $n = 0;
        while($n < 5) {
            DB::table('contacts')->insert([
                    'ask_category' => 'お問合わせ',
                    'user_name' => 'あいうえお',
                    'user_email' => 'bonjour@frank.fam.cx',
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
