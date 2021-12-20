<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Manager;
use App\Models\Source;
use DB;
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
        $array = [
            'fb',
            'tg',
            'website',
            'client',
            'partner'
        ];
        for ($i=0; $i < count($array); $i++){
            Source::query()->create([
                'title' => $array[$i]
            ]);
        }
        Client::factory(['source_id' => 1])->count(100)->create();
        Client::factory(['source_id' => null])->count(10)->create();
        Manager::factory()->count(30)->create();

        $managersCount = Manager::query()->get()->count();


        for ($i = 1; $i <= 3; $i++) {
            Client::query()->get()->map(function ($client) use ($managersCount) {
                $client->managers()->attach(rand(1, $managersCount), ['fee' => rand(50, 2000)]);
            });
        }

        // \App\Models\User::factory(10)->create();
    }
}
