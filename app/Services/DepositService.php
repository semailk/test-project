<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Client;
use App\Models\Deposit;
use Carbon\Carbon;

class DepositService
{
    /**
     * @param $request
     * @return int
     */
    public function store($request): int
    {
        $deposit = new Deposit();
        $deposit->client_id = $request->client_id;
        $deposit->value = $request->value;
        $deposit->date = Carbon::now()->toDateString();
        $deposit->save();

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
    public function withdraw($request): void
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
                        $newCertificate = new Certificate();
                        $newCertificate->client_id = $request->client_id;
                        $newCertificate->shares = $certificate->shares - $withdraw;
                        $newCertificate->number = $certificate->number + 1;
                        $newCertificate->name = $certificate->name;
                        $newCertificate->canceled_at = null;
                        $newCertificate->canceled_shares = 0;

                        $newCertificate->save();
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
            $certificate = new Certificate();
            $certificate->client_id = $id;
            $certificate->shares = $countBuyCertificates;
            $certificate->name = $client->name;
            $certificate->number = $certificate->number + 1;
            $certificate->canceled_shares = 0;
            $certificate->canceled_at = null;
            $certificate->save();

            $client->balance = $client->balance - ($countBuyCertificates * 1000);
            $client->save();
        }

        return $countBuyCertificates;
    }
}
