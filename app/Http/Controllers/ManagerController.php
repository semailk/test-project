<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Carbon\Carbon;
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
        $managers = Manager::query()->with(['clients'])->get();

        return view('manager.index', compact('managers'));
    }

    /**
     * @param Request $request
     */
    public function plainEdit(Request $request): void
    {
        Manager::query()->find($request->id)->update([
            'plain' => [
                'quarter_' . Carbon::now()->quarter => $request->plain
            ]
        ]);
    }

    public function plainAction()
    {
        $managers = Manager::all();
        return \view('manager.plain',
            compact('managers'));
    }

    public function plainCreate(Request $request)
    {
        Manager::find($request->manager_id)->forceFill([
            'plain->' . $request->quarter => $request->plain
        ])->save();

        return redirect()->back();
    }

    public function getPlain()
    {
        $manager = Manager::find(\request()->id)->only('plain');
        return $manager;
    }
}
