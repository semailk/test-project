<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Manager;
use App\Models\Role;
use App\Models\Source;
use App\Models\User;
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
        $roles = ['sales', 'senior_sales', 'head_of_sales', 'admin'];
        $i = 0;
        while (count($roles) > $i):
            DB::table('roles')
                ->insert([
                    'name' => $roles[$i]
                ]);
            $i++;
        endwhile;
        $array = [
            'fb',
            'tg',
            'website',
            'client',
            'partner'
        ];
        for ($i = 0; $i < count($array); $i++) {
            Source::query()->create([
                'title' => $array[$i]
            ]);
        }
        User::factory(['role_id' => Role::all()->random()->id])->count(10)->has(Client::factory(['source_id' => 1])->count(5), 'clients')->create();
        User::factory(['role_id' => Role::all()->random()->id])->count(10)->has(Client::factory(['source_id' => null])->count(1), 'clients')->create();

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
