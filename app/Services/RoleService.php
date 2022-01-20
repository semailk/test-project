<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Manager;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Ramsey\Collection\Collection;

class RoleService
{

    public const ROLE = [
        1 => 'sales',
        2 => 'senior_sales',
        3 => 'head_of_sales',
        4 => 'admin'
    ];


    /**
     * @param Builder $managers
     * @return Builder
     */
    public function filter(Builder $managers): Builder
    {
        $role = self::ROLE[auth()->user()->role_id];

        if ($role === 'admin') {

            return $managers;
        } elseif ($role === 'sales') {
            $managers->where('user_id', auth()->id());

            return $managers;
        } elseif ($role === 'senior_sales') {
            $users = User::where('parent_id', auth()->id())->where('role_id', 1)->get()->pluck('id');
            $users->add(auth()->id());
            $managers->whereIn('user_id', $users);

            return $managers;
        } elseif ($role === 'head_of_sales') {

            $usersIds = User::where('parent_id', auth()->id())->where('role_id', '<', 3)->get()->pluck('id');

            $seniorSales =  User::where('parent_id', auth()->id())->where('role_id', 2)->get()->pluck('id');
            $salesIds = User::query()->whereIn('parent_id', $seniorSales)->get()->pluck('id');
            $usersIds->merge($salesIds);
            $usersIds->add(auth()->id());
            $managers->whereIn('user_id', $usersIds);

            return $managers;
        }
        abort(422);
    }
}
