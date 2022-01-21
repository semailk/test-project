<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\DepositService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepositController extends Controller
{
    public function __construct(public DepositService $depositService)
    {
    }

    public function index()
    {
        $clients = Client::all();
        return view('deposit.index', compact('clients'));
    }

    /**
     * @return View
     */
    public function create($id): View
    {
        $client = Client::query()->with(['deposits', 'certificates'])->findOrFail($id);

        return view('deposit.create', compact('client'));
    }


    public function store(Request $request)
    {
        $newBalance = $this->depositService->store($request);
        return redirect()->back()->with(['success' => 'Вы пополнини баланс.И теперь ваш баланс составляет : ' . $newBalance . '$.']);
    }

    public function withdrawT(Request $request)
    {
        if (Client::query()->find($request->client_id)->certificatesSum() < $request->withdraw) {
            return redirect()->back()->withErrors(['errors' => 'Недостаточно акций!']);
        }
        $this->depositService->withdraw($request);
        return redirect()->back()->with(['success' => 'Вы успешно вывели - ' . $request->withdraw . ' акции']);
    }

    public function exchangeDeposit($id)
    {
        $countBuyCertificates = $this->depositService->exchangeDeposit($id);
        return redirect()->back()->with(['success' => 'Вы преобрели: ' . $countBuyCertificates . ' акций.']);
    }
}
