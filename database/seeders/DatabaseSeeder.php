<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Manager;
use App\Models\Source;
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
        Client::factory()->count(100)->has(Source::factory()->count(1))->create();
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
