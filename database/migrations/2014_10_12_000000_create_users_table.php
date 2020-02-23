<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //Schema::defaultStringLength(200); 
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('firstname')->length(80);
            $table->string('lastname')->length(80);
            $table->string('email')->length(100)->unique();
            $table->integer('admin')->default(0);
            $table->integer('subscribed')->default(0);
            $table->string('password');
            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

            DB::table('users')->insert(
                ['id' => 1, 
                'firstname' => 'jason', 
                'lastname' => 'bronson', 
                'email' => 'jasonbronson@gmail.com', 
                'admin'=> 0,
                'subscribed' => 0,
                'password' => '$2y$10$ME7ifyG1yf/vQlf1pAlE2ur/s6SSltoloLmC1yaXpRWkpj9WSf0d6', 
                'remember_token' => NULL, 
                'created_at' => '2017-10-08 22:29:00', 
                'updated_at' => '2017-10-08 22:29:00']
            );    
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
