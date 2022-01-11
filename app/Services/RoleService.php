<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Ramsey\Collection\Collection;

class RoleService
{

    public function roleFilter($qb)
    {
        $result = match (auth()->user()->role->name) {
            'sales' => $this->filter($qb, 'sales'),
            'senior_sales' => $this->filter($qb, 'senior_sales'),
            'head_of_sales' => $this->filter($qb, 'head_of_sales'),
            'admin' => $this->filter($qb, 'admin'),
        };

        return $result;
    }

    public function filter($qb, $role)
    {
        if ($role === 'admin') {
            return $qb;
        } elseif ($role === 'sales') {
            $qb->where('user_id', \Auth::id());
            return $qb;
        } elseif ($role === 'senior_sales') {
            $users = User::where('parent_id', auth()->id())->get()->pluck('id');
            $users->add(\Auth::id());
            $clients = Client::query()->whereIn('user_id',$users);

            return $clients;
        } elseif ($role === 'head_of_sales') {
            $users = User::where('parent_id', auth()->id())->get()->pluck('id');
            $users->add(\Auth::id());
            $clients = Client::query()->whereIn('user_id',$users);

            return $clients;
        }

        return $result;
    }
}
