<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        Eloquent::unguard();
        $path = 'database/seeds/states.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('States table seeded!');
                

    }
}
