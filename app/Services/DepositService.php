<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Client;
use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepositService
{
    public function __construct(public Deposit $deposit)
    {
        //
    }

    /**
     * @param $request
     * @return int
     */
    public function store(Request $request): int
    {
        Deposit::create([
           'client_id' =>  $request->client_id,
            'value' => $request->value,
            'date' => Carbon::now()->toDateString(),
        ]);

        /** @var Client $client */
        $client = Client::query()->findOrFail($request->client_id);
        $client->balance += $request->value;
        $newBalance = $client->balance;
        $client->save();

        return $newBalance;
    }

    /**
     * @param $request
     */
    public function withdraw(Request $request): void
    {
        $withdraw = $request->withdraw;

        Certificate::query()
            ->where('client_id', $request->client_id)
            ->whereNull('canceled_at')
            ->get()
            ->each(function (Certificate $certificate) use (&$withdraw, $request) {
                if ($certificate->shares <= $withdraw) {
                    $certificate->canceled_at = Carbon::now()->toDateTimeString();
                    $certificate->canceled_shares = $certificate->shares;
                    $certificate->save();
                    $withdraw -= $certificate->shares;
                } else {
                    if ($withdraw <= 0) {
                        return;
                    }
                    $certificate->canceled_shares = $request->withdraw;
                    $certificate->canceled_at = Carbon::now()->toDateTimeString();
                    if ($withdraw > 0) {
                        Certificate::create([
                            'client_id' => $request->client_id,
                            'shares' => $certificate->shares - $withdraw,
                            'number' => $certificate->number + 1,
                            'name' => $certificate->name,
                            'canceled_at' => null,
                            'canceled_shares' => 0
                        ]);
                    }
                    $certificate->save();
                    $withdraw -= $certificate->shares;

                }
            });
    }

    /**
     * Обмениваем депозит на акции
     */
    public function exchangeDeposit(Client $client)
    {
        $countBuyCertificates = (int)($client->balance / 1000);

        $lastCertificate = Certificate::query()
            ->where('client_id', $client->id)
            ->orderByDesc('number')
            ->take(1)
            ->first();

        if ($countBuyCertificates >= 1) {
            Certificate::create([
               'client_id' => $client->id,
                'shares' => $countBuyCertificates,
                'name' => $client->name,
                'number' => ($lastCertificate->number > 1) ? + 1 : 1,
                'canceled_shares' => 0 ,
                'canceled_at' => null
            ]);

            $client->balance -= ($countBuyCertificates * 1000);
            $client->save();
        }

        return $countBuyCertificates;
    }
}
