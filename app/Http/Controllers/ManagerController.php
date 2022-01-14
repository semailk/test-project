<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\ManagerPlain;
use App\Services\RoleService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagerController extends Controller
{
    public function __construct(public RoleService $roleService)
    {
        //
    }

    /**
     * Страница Менеджеров
     *
     * @return View
     */
    public function index(): View
    {
        $managers = $this->roleService->filter(Manager::query()->with(['clients.deposits', 'managerPlains']));
        return view('manager.index', [
            'managers' => $managers->get()
        ]);
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


    /**
     * Страница плана менеджера
     *
     * @return View
     */
    public function plainAction(): View
    {
        $managers = Manager::all();


        return \view('manager.plain',
            compact('managers'));
    }

    /**
     * Создания плана для менеджера
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function plainCreate(Request $request): RedirectResponse
    {

        $quarter = match ($request->quarter) {
            '1' => '01-01',
            '2' => '01-04',
            '3' => '01-07',
            '4' => '01-10'
        };

        $date = $request->year . '-' . $quarter;
        $managerPlain = ManagerPlain::query()->where('manager_id', $request->manager_id)
            ->where('date', $date)->first();
        if (empty($managerPlain)) {
            ManagerPlain::query()->create([
                'manager_id' => $request->manager_id,
                'date' => $date,
                'plain' => $request->plain
            ]);
        } else {
            $managerPlain->update([
                'date' => $date,
                'plain' => $request->plain
            ]);
        }
        return redirect()->back();
    }

    /**
     * Возвращения данных на AJAX запрос
     *
     * @return mixed
     */
    public function getPlain()
    {
        $plains = Manager::find(\request()->id)->managerPlains->map(function (ManagerPlain $managerPlain) {
            return $managerPlain->only(['date', 'plain']);
        });

        return $plains->toArray();
    }
}
