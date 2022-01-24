<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositStoreRequest;
use App\Http\Requests\WithdrawRequest;
use App\Models\Client;
use App\Services\DepositService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DepositController extends Controller
{
    public function __construct(public DepositService $depositService)
    {
    }

    /**
     * Главная страница клиентов
     *
     * @return View
     */
    public function index(): View
    {
        $clients = Client::all();
        return view('deposit.index', compact('clients'));
    }

    /**
     * Страница клиента для создания или обмена акций
     *
     * @param $id
     * @return View
     */
    public function create($id): View
    {
        $client = Client::query()->with(['deposits', 'certificates'])->findOrFail($id);

        return view('deposit.create', compact('client'));
    }


    /**
     * Пополнения баланса
     *
     * @param DepositStoreRequest $depositStoreRequest
     * @return RedirectResponse
     */
    public function store(DepositStoreRequest $depositStoreRequest): RedirectResponse
    {
        $newBalance = $this->depositService->store($depositStoreRequest);
        return redirect()->back()->with(['success' => 'Вы пополнини баланс.И теперь ваш баланс составляет : ' . $newBalance . '$.']);
    }

    /**
     * Вывод акций
     *
     * @param WithdrawRequest $request
     * @return RedirectResponse
     */
    public function withdrawT(WithdrawRequest $request): RedirectResponse
    {
        if (Client::query()->find($request->client_id)->certificatesSum() < $request->withdraw) {
            return redirect()->back()->withErrors(['errors' => 'Недостаточно акций!']);
        }
        $this->depositService->withdraw($request);
        return redirect()->back()->with(['success' => 'Вы успешно вывели - ' . $request->withdraw . ' акции']);
    }

    /**
     * Обмен баланса на акции
     *
     * @param $id
     * @return RedirectResponse
     */
    public function exchangeDeposit($id): RedirectResponse
    {
        $countBuyCertificates = $this->depositService->exchangeDeposit($id);
        return redirect()->back()->with(['success' => 'Вы преобрели: ' . $countBuyCertificates . ' акций.']);
    }
}