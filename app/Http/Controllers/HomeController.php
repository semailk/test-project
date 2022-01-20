<?php

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\Manager;
use App\Services\RoleService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(public RoleService $roleService)
    {
        $this->middleware('auth');
    }

    /**
     * @return View
     */
    public function index(): View
    {
        if (\request()->path() !== '/') {
            $managers = Client::with(['clients', 'clients', 'managerPlains'])->get()->whereNull('source_id');
            $managers = $this->roleService->filter($managers)->get();
        } else {
            $managers = Manager::with(['clients', 'clients', 'managerPlains']);
            $managers = $this->roleService->filter($managers)->get();
        }
        $clientSum = $managers->map(function (Manager $manager) {
            return $manager->clients->count();
        });

        $clientInfo['count'] = $clientSum->sum();
        $clientInfo['deleted'] = $managers->whereNotNull('clients.deleted_at')->count();
        $clientInfo['dont_source'] = $managers->whereNotNull('clients.source_id');

        return \view('welcome', [
            'managers' => $managers,
            'clientInfo' => $clientInfo
        ]);
    }

    public function userExit()
    {
        Auth::logout();
        return redirect()->back();
    }
}
