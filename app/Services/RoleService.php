<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Manager;
use App\Models\Role;
use App\Models\User;
use Ramsey\Collection\Collection;

class RoleService
{

    public const ROLE = [
        1 => 'sales',
        2 => 'senior_sales',
        3 => 'head_of_sales',
        4 => 'admin'
    ];


    public function filter($qb)
    {
        $role = self::ROLE[auth()->user()->role_id];

        if ($role === 'admin') {
            return $qb;
        } elseif ($role === 'sales') {
            $qb->where('user_id', \Auth::id());
            return $qb;
        } elseif ($role === 'senior_sales') {
            $users = User::where('parent_id', auth()->id())->where('role_id', 1)->get()->pluck('id');
            $users->add(auth()->id());
            $managers = $qb->whereIn('user_id', $users);

            return $managers;
        } elseif ($role === 'head_of_sales') {
            $users = User::where('parent_id', auth()->id())->where('role_id', '<', 3)->get()->pluck('id');
            $users->add(auth()->id());
            $managers = $qb->whereIn('user_id', $users);

            return $managers;
        }
    }
}
