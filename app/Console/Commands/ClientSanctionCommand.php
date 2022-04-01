<?php

namespace App\Console\Commands;

use App\Http\Controllers\SanctionController;
use App\Models\Client;
use Illuminate\Console\Command;

class ClientSanctionCommand extends Command
{
    private string $url = 'https://hki4m36joj.execute-api.us-east-1.amazonaws.com/search';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:sanction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search for clients who have sanctions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // Проверка на сущестование и очистка
        // лога при запуске крона

        $file = public_path('../storage/logs/sanction.log');
        if (file_exists($file)) {
            file_put_contents($file, '');
        }

        Client::all()->each(function (Client $client) {
            sleep(1);
            $search = [
                'size' => strlen($client->name),
                'entity_type' => ['individual'],
                'all_programs' => true,
                'keyword' => $client->name
            ];

            $response = SanctionController::responseDTO(\Http::post($this->url, $search));

            foreach ($response as $item) {
                if ($item['entity_name'] === $client->name && $item['birthdate'] === $client->dateOfBirthCarbon) {
                    \Log::channel('sanction')->warning('ID: ' . $client->id . ' ' . $client->name . ' есть санкции - ' . $item['url']);
                }
            }
        });

        return 0;
    }
}
