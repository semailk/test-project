<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Deposit;
use App\Models\Manager;
use App\Models\ManagerPlain;
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



        foreach ($roles as $role) {
            Role::query()->create([
                'name' => $role
            ]);
        }

        $array = [
            'fb',
            'tg',
            'website',
            'client',
            'partner'
        ];
        foreach ($array as $value){
            Source::query()->create([
                'title' => $value
            ]);
        }


    Manager::factory()->count(30)
        ->has(ManagerPlain::factory(), 'managerPlains')
        ->has(Client::factory(['source_id' => 1])->count(5)
        ->has(Deposit::factory()->count(3), 'deposits')
        ->for(User::factory(['role_id' => Role::all()->random()->id]), 'user'), 'clients')
        ->create();

    Manager::factory()->count(5)->has(ManagerPlain::factory(), 'managerPlains')
        ->has(Client::factory()->count(1)
        ->has(Deposit::factory()->count(3), 'deposits')
        ->for(User::factory(['role_id' => Role::all()->random()->id]), 'user'), 'clients')
        ->create();

        User::query()->create([
            'name' => 'admin',
            'role_id' => 4,
            'email' => 'admin@mail.ru',
            'password' => \Hash::make('qweqweqwe')
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
