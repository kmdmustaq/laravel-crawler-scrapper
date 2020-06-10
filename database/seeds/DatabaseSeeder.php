<?php

use App\Location;
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
        // $this->call(UsersTableSeeder::class);

        factory(Location::class, 1)->create();
        factory(Location::class, 1)->make([
            'location' => 'India',
            'level' => 0,
            'parent' => 1
        ]);
    }
}
