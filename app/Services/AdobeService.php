<?php

namespace App\Services;

use App\Models\Certificate;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use JsonException;

class AdobeService
{
    /**
     * @param Certificate $certificate
     * @return bool
     * @throws GuzzleException
     * @throws JsonException
     */
    public static function downloadPdfFile(Certificate $certificate): bool
    {
        $client = new Client();

        try {
            $response = $client->request("POST", config('adobe.url'), [

                'headers' => config('adobe.adobe'),
                'multipart' => [
                    [
                        'name' => 'contentAnalyzerRequests',
                        'contents' => json_encode([
                            'cpf:engine' => [
                                'repo:assetId' => 'urn:aaid:cpf:Service-52d5db6097ed436ebb96f13a4c7bf8fb'
                            ],
                            'cpf:inputs' => [
                                'documentIn' => [
                                    'dc:format' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                    'cpf:location' => 'uploaded_file',
                                ],
                                'params' => [
                                    'cpf:inline' => [
                                        'outputFormat' => 'pdf',
                                        'jsonDataForMerge' => [
                                            'CLIENT_NAME' => $certificate->client->name,
                                            'NUMBER' => $certificate->number,
                                            'ADDRESS' => $certificate->client->email,
                                            'COUNT' => $certificate->shares
                                        ],
                                    ]
                                ],
                            ],
                            'cpf:outputs' => [
                                'documentOut' => [
                                    'dc:format' => "application/pdf",
                                    'cpf:location' => 'multipartLabel'
                                ]
                            ]
                        ], JSON_THROW_ON_ERROR)
                    ],
                    [
                        'name' => 'uploaded_file',
                        'filename' => 'test.pdf',
                        'Mime-Type' => 'pdf',

                        'contents' => fopen('test.docx', 'r'),
                    ]
                ]
            ]);
            file_put_contents('certificates/' . $certificate->uuid . '.' . Carbon::now()->toDateString() . '.pdf', $response->getBody()->getContents());

            return true;
        } catch (ClientException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
