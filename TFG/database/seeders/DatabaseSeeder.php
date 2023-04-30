<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CantorSeeder::class);
        $this->call(DirectorSeeder::class);
        $this->call(PartituraSeeder::class);
        $this->call(AudioSeeder::class);        
        $this->call(VideoSeeder::class);
        $this->call(RelUsuarioCoroSeeder::class);
    }
}
