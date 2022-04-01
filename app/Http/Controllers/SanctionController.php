<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SanctionController extends Controller
{
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
            'size' => strlen($request->name),
            'entity_type' => [$request->ind === 2 ? 'organization' : 'individual'],
            'all_programs' => true,
            'keyword' => $request->name
        ];

        $response = \Http::post('https://hki4m36joj.execute-api.us-east-1.amazonaws.com/search', $search);


        return $this->responseDTO($response);
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

        $response = \Http::post('https://hki4m36joj.execute-api.us-east-1.amazonaws.com/search', $search);


        return \view('sanction.index', [
            'response' => $this->responseDTO($response)
        ]);
    }

    /**
     * @param $response
     * @return array
     */
    public static function responseDTO($response): array
    {
        $result = [];
        $array = json_decode($response->body(), true)['result']['data'];
        for ($i = 0; $i < count($array); $i++) {
            if (isset($array[$i]['source_links'][0]) &&
                isset($array[$i]['entity_name']) &&
                isset($array[$i]['birthdate'])
            ) {
                $result[$i]['url'] = $array[$i]['source_links'][0]['url'];
                $result[$i]['entity_name'] = $array[$i]['entity_name'][0]['value'];
                $result[$i]['birthdate'] = $array[$i]['birthdate'][count($array[$i]['birthdate']) - 1]['value']['dateOfBirth'];
            }

        }

        return $result;
    }
}
