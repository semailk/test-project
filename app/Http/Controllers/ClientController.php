<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientUpdateRequest;
use App\Http\Requests\ClientStoreRequest;
use App\Models\Client;
use App\Models\Manager;
use App\Models\Source;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Главная страница
     *
     * @return View
     */
    public function index(): View
    {
        $clientInfo['count'] = Client::query()->get()->count();
        $clientInfo['deleted'] = Client::query()->withTrashed()->whereNotNull('deleted_at')->get()->count();
        $clientInfo['dont_source'] = Client::query()->whereNull('source_id')->get();
        $clients = Client::query()->with(['managers','source'])->orderBy('created_at', 'desc')->paginate(10);

        return view('main.index', compact('clients', 'clientInfo'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $managers = Manager::query()->get();
        $sources = Source::query()->get();

        return \view('main.create', compact('managers', 'sources'));
    }

    /**
     * Вывод страницы редактирования клиента
     *
     * @param Client $client
     * @return View
     */
    public function edit(Client $client): View
    {
        $managers = Manager::query()->get();
        $sources = Source::query()->get();

        return \view('main.edit', compact('client', 'managers', 'sources'));
    }

    /**
     * Обновление клиента
     *
     * @param ClientUpdateRequest $request
     * @param Client $client
     * @return RedirectResponse
     */
    public function update(ClientUpdateRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());
        $managersId = $request->get('manager_id');
        $fees = $request->get('fee');

        $syncData = [];
        foreach ($managersId as $key => $managerId) {
            $syncData[$managerId] = ['fee' => $fees[$key]];
        }

        $client->managers()->sync($syncData);

        return redirect()->back()->with(['success' => 'Updated successfully!']);
    }

    /**
     * Удаление клиента
     *
     * @param Client $client
     * @return RedirectResponse
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->back()->with(['success' => 'Deleted successfully!']);
    }

    /**
     * @param ClientStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ClientStoreRequest $request): RedirectResponse
    {
        $client = Client::query()->create($request->validated());
        foreach ($request->get('manager_id') as $key => $manager_id) {
            if ($manager_id != null) {
                if ($request->get('fee')[$key] != null) {
                    $client->managers()->attach($manager_id, ['fee' => $request->get('fee')[$key]]);
                }
            }
        }
        return redirect()->back()->with(['success' => 'Client created!']);
    }
}
