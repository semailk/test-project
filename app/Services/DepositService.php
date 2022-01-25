<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Client;
use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepositService
{
    public function __construct(public Deposit $deposit, public Certificate $certificate)
    {
        //
    }

    /**
     * @param $request
     * @return int
     */
    public function store(Request $request): int
    {
        $this->deposit->client_id = $request->client_id;
        $this->deposit->value = $request->value;
        $this->deposit->date = Carbon::now()->toDateString();
        $this->deposit->save();

        /** @var Client $client */
        $client = Client::query()->findOrFail($request->client_id);
        $client->balance = $client->balance + $request->value;
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
                    $withdraw = $withdraw - $certificate->shares;
                } else {
                    if ($withdraw <= 0) {
                        return;
                    }
                    $certificate->canceled_shares = $request->withdraw;
                    $certificate->canceled_at = Carbon::now()->toDateTimeString();
                    if ($withdraw > 0) {
                        $this->certificate->client_id = $request->client_id;
                        $this->certificate->shares = $certificate->shares - $withdraw;
                        $this->certificate->number = $certificate->number + 1;
                        $this->certificate->name = $certificate->name;
                        $this->certificate->canceled_at = null;
                        $this->certificate->canceled_shares = 0;

                        $this->certificate->save();
                    }
                    $certificate->save();
                    $withdraw = $withdraw - $certificate->shares;

                }
            });
    }

    /**
     * Обмениваем депозит на акции
     *
     * @param $id
     * @return int
     */
    public function exchangeDeposit($id): int
    {
        /** @var Client $client **/
        $client = Client::query()->findOrFail($id);
        $countBuyCertificates = (int)($client->balance / 1000);
        if ($countBuyCertificates >= 1) {
            $this->certificate->client_id = $id;
            $this->certificate->shares = $countBuyCertificates;
            $this->certificate->name = $client->name;
            $this->certificate->number = $this->certificate->number + 1;
            $this->certificate->canceled_shares = 0;
            $this->certificate->canceled_at = null;
            $this->certificate->save();

            $client->balance = $client->balance - ($countBuyCertificates * 1000);
            $client->save();
        }

        return $countBuyCertificates;
    }
}
