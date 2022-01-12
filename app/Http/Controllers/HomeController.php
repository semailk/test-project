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
            $clients = Client::with(['managers.clients', 'source', 'deposits'])->get()->whereNull('source_id');
            $clients = $this->roleService->roleFilter($clients);
        } else {
            $clients = Client::with(['managers.clients', 'source', 'deposits']);
            $clients = $this->roleService->roleFilter($clients)->withTrashed()->get();
        }

        $clients->map(function (Client $client) {
            $client->managers->map(function (Manager $manager) {
                $manager->clients->map(function (Client $client) use (&$manager) {
                    $manager->deposits = $client->deposits->sum('value');
                    $manager->completed = round($client->deposits->sum('value') / $manager->plain['quarter_' . Carbon::now()->quarter] * 100);
                });
            });
        });
        $clientInfo['count'] = $clients->whereNull('deleted_at')->count();
        $clientInfo['deleted'] = $clients->whereNotNull('deleted_at')->count();
        $clientInfo['dont_source'] = $clients->whereNull('source_id');

        return \view('welcome', [
            'clients' => $clients,
            'clientInfo' => $clientInfo
        ]);
    }

    public function userExit()
    {
        Auth::logout();
        return redirect()->back();
    }
}
