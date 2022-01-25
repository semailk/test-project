<?php

namespace Database\Seeders;

use App\Models\Certificate;
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
        foreach ($array as $value) {
            Source::query()->create([
                'title' => $value
            ]);
        }


        User::factory()->count(30)->has(Manager::factory()
            ->has(ManagerPlain::factory(), 'managerPlains')
            ->has(Client::factory(['source_id' => 1, 'balance' => 50000])->count(5)
                ->has(Deposit::factory()->count(3), 'deposits'), 'clients')
            ->for(User::factory()->count(30), 'user'))
            ->create();

        User::query()->create([
            'name' => 'admin',
            'role_id' => 4,
            'email' => 'admin@mail.ru',
            'password' => \Hash::make('qweqweqwe')
        ]);

        User::query()->get()->each(function (User $user) {
            if ($user->id != 31) {
                $user->parent_id = 31;
                $user->save();
            }
        });

        $this->certificateCreate();
    }

    public function certificateCreate(): void
    {
        Client::query()->get()->each(function (Client $client) {
            $certificate = new Certificate();
            $certificate->client_id = $client->id;
            $certificate->name = $client->name;
            $certificate->shares = random_int(1, 50);
            $certificate->number = 1;
            $certificate->save();

            $certificate = new Certificate();
            $certificate->client_id = $client->id;
            $certificate->name = $client->name;
            $certificate->shares = random_int(1, 50);
            $certificate->number = 2;
            $certificate->save();

            $certificate = new Certificate();
            $certificate->client_id = $client->id;
            $certificate->name = $client->name;
            $certificate->shares = random_int(1, 50);
            $certificate->number = 3;
            $certificate->save();
        });
    }
}
