<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Client;
use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DepositService
{
    /**
     * @param Request $request
     * @return int
     */
    public function store(Request $request): int
    {
        $rules = [
            'client_id' => [
                'required',
                'numeric',
                Rule::exists('clients', 'id'),
            ],
            'value' => [
                'required',
                'numeric',
                'min:1'
            ]
        ];

        $request->validate($rules);

        $deposit = new Deposit();
        $deposit->client_id = $request->client_id;
        $deposit->value = $request->value;
        $deposit->date = Carbon::now()->toDateString();
        $deposit->save();
        $client = Client::query()->findOrFail($request->client_id);
        $client->balance = $client->balance + $request->value;
        $newBalance = $client->balance;
        $client->save();

        return $newBalance;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function withdraw(Request $request): void
    {

        $rules = [
            'client_id' => [
                'required',
                'numeric',
                Rule::exists('clients', 'id'),
            ],
            'withdraw' => [
                'required',
                'numeric',
                'min:1'
            ]
        ];

        $request->validate($rules);

        $certificates = Certificate::query()
            ->where('client_id', $request->client_id)
            ->whereNull('canceled_at')
            ->get();
        $withdraw = $request->withdraw;

        foreach ($certificates as $certificate) {
            if ($certificate->shares <= $withdraw) {
                $certificate->canceled_at = Carbon::now()->toDateTimeString();
                $certificate->canceled_shares = $certificate->shares;
                $certificate->save();
                $withdraw = $withdraw - $certificate->shares;
            } else {
                $certificate->canceled_shares = $request->withdraw;
                $certificate->canceled_at = Carbon::now()->toDateTimeString();

                if (($certificate->shares - $withdraw) > 0) {
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
            }
        }
    }

    /**
     * Обмениваем депозит на акции
     *
     * @param $id
     * @return int
     */
    public function exchangeDeposit($id): int
    {
        $client = Client::query()->findOrFail($id);
        $canceledShares = Certificate::query()->where('client_id', $id)->get()->sum('canceled_shares');
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
