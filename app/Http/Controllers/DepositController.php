<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositStoreRequest;
use App\Http\Requests\WithdrawRequest;
use App\Models\Client;
use App\Services\DepositService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
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
     * @param Client $client
     * @return View
     */
    public function create(Client $client): View
    {
        $client->with(['deposits', 'certificates']);

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
     * @param Client $client
     * @return RedirectResponse
     */
    public function exchangeDeposit(Client $client): RedirectResponse
    {
        $countBuyCertificates = $this->depositService->exchangeDeposit($client);
        return redirect()->back()->with(['success' => 'Вы преобрели: ' . $countBuyCertificates . ' акций.']);
    }


    /**
     * @param Client $client
     * @return \Illuminate\Http\Response
     */
    public function pdfStore(Client $client)
    {
            $headers = [
                'x-api-key' => '2cec001c6c96478789a987951b5bfda4',
                'Accept' => 'application/json, text/plain, */*',
                'Authorization' => 'Bearer eyJhbGciOiJSUzI1NiIsIng1dSI6Imltc19uYTEta2V5LWF0LTEuY2VyIiwia2lkIjoiaW1zX25hMS1rZXktYXQtMSIsIml0dCI6ImF0In0.eyJpZCI6IjE2NDgwOTgzMjgzNTdfMGI5MjhjMmItYTE2NC00NWY2LTg0MmYtY2ZkNzcyMjRlYzFmX3VlMSIsInR5cGUiOiJhY2Nlc3NfdG9rZW4iLCJjbGllbnRfaWQiOiIyY2VjMDAxYzZjOTY0Nzg3ODlhOTg3OTUxYjViZmRhNCIsInVzZXJfaWQiOiI2NkZCMUU3QzYyMzk4ODk0MEE0OTVGODlAdGVjaGFjY3QuYWRvYmUuY29tIiwiYXMiOiJpbXMtbmExIiwiYWFfaWQiOiI2NkZCMUU3QzYyMzk4ODk0MEE0OTVGODlAdGVjaGFjY3QuYWRvYmUuY29tIiwiY3RwIjowLCJmZyI6IldKUVBDNzZWRkxFNUlQVUNFTVFGUkhRQVNBPT09PT09IiwibW9pIjoiMjA3NmY4IiwiZXhwaXJlc19pbiI6Ijg2NDAwMDAwIiwiY3JlYXRlZF9hdCI6IjE2NDgwOTgzMjgzNTciLCJzY29wZSI6Im9wZW5pZCxEQ0FQSSxBZG9iZUlELGFkZGl0aW9uYWxfaW5mby5vcHRpb25hbEFncmVlbWVudHMifQ.XQen272e5GEIJxRn3qmcyWsZlyGhCwZPXgfNwkayM0XlFUSPGj0SezWiEKD0RO6U7H2Ktzqp-tcf2tj55bCchNyl5RAM0Ag3177oI9hpOU8CcxlVtmT5szOcPKERVcwiQclUMIFkAC-wyhr7j6Et2MTIOhzvEVHvVl9Q1CIIgHeezxNwkXUawR0rweXwxbdz_lFRkfzRxmVyUeSJts4DCR5xse4gyOJCv3zTW3Eb5q26rkVoCb0MbYQcTHqswExjRNkZZqrTv0mF3dUDHyF5x_2XeR5F6SVh2BtgWIi328YmDNd5HML1wPd6W-3EJ9WPnR_Db6xuE1HraAeRA_x1cA',
                'Prefer' => 'respond-async,wait=0',
            ];

            $client = new \GuzzleHttp\Client();

            /** Guzzle CURL POST request */
            $response = $client->request("POST", 'https://cpf-ue1.adobe.io/ops/:create?respondWith=%7B%22reltype%22%3A%20%22http%3A%2F%2Fns.adobe.com%2Frel%2Fprimary%22%7D', [
                /** Multipart form data is your actual file upload form */
                'headers' => $headers,
                'multipart' => [
                    [
                        /** This is the actual fields name that you will use to access in API */
                        'name' => 'uploaded_file',
                        'filename' => 'test.pdf',
                        'Mime-Type'=> 'pdf',

                        /** This is the main line, we are reading from
                         * ﻿f﻿ile temporary uploaded location  */
                        'contents' => fopen('test.pdf', 'r'),
                    ],
                    /** Other form fields here, as we can't send form_fields with multipart same time */
                    [
                        /** This is the form filed that we will use to acess in API */
                        'name' => 'form-data',
                        /** We need to use json_encode to send the encoded data */
                        'contents' => json_encode(
                            [
                                'cpf:inline' => [
                                    'outputFormat' => 'pdf',
                                    'jsonDataForMerge' => [
                                        'itemsBought' => [
                                            'client_name' => 'Ruslan',
                                            'number' => 123,
                                            'address' => 'Zaleskaya 77',
                                            'count' => 10
                                        ],
                                    ],
                                ]
                            ]
                        )
                    ]
                ]
            ]);
            dd($response);
    }
}
