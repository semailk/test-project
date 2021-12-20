<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
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
        $clientCount = Client::query()->get()->count();
        $clients = Client::query()->orderBy('created_at', 'desc')->paginate(10);


        return view('main.index', compact('clients', 'clientCount'));
    }

    /**
     * Вывод страницы редактирования клиента
     *
     * @param Client $client
     * @return View
     */
    public function edit(Client $client): View
    {
        return \view('main.edit', compact('client'));
    }

    /**
     * Обновление клиента
     *
     * @param ClientRequest $request
     * @param Client $client
     * @return RedirectResponse
     */
    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

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
}
