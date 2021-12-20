<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagerController extends Controller
{
    /**
     * Страница Менеджеров
     *
     * @return View
     */
    public function index(): View
    {
        $managers = Manager::query()->has('clients')->get();

        return view('manager.index', compact('managers'));
    }
}
