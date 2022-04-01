<?php

namespace App\Http\Controllers;

use App\Services\SanctionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SanctionController extends Controller
{
    private string $url = 'https://hki4m36joj.execute-api.us-east-1.amazonaws.com/search';

    public function __construct(protected SanctionService $sanctionService)
    {
        //
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('sanction.index');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function editAjax(Request $request): array
    {
        $search = [
            'size' => 10,
            'entity_type' => ['organization' , 'individual'] ,
            'all_programs' => true,
            'keyword' => $request->name
        ];

        $response = \Http::post($this->url, $search);

        return $this->sanctionService->responseDTO($response);
    }

    /**
     * @param $name
     * @return View
     */
    public function getName($name): View
    {
        $search = [
            'size' => strlen($name),
            'entity_type' => ['individual'],
            'all_programs' => true,
            'keyword' => $name
        ];

        $response = \Http::post($this->url, $search);

        return \view('sanction.index', [
            'response' => $this->sanctionService->responseDTO($response)
        ]);
    }
}
