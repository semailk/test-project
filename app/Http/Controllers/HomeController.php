<?php

namespace App\Http\Controllers;


use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        if (\request()->path() !== '/'){
            $clients = Client::with(['managers'])->get()->whereNull('source_id');
        }else{
            $clients = Client::with(['managers','source'])->get()->take(10);
        }

        $clientInfo['count'] = Client::query()->get()->count();
        $clientInfo['deleted'] = Client::query()->withTrashed()->whereNotNull('deleted_at')->get()->count();
        $clientInfo['dont_source'] = Client::query()->whereNull('source_id')->get();

        return \view('welcome', compact('clients', 'clientInfo'));
    }
}
