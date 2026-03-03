<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClientsApi
{
    /**
     * Get the base HTTP client configuration.
     *
     * @return \Illuminate\Http\Client\PendingRequest
     */
    protected function client()
    {
        $baseUrl = config('services.documanage_api.base_url');
        $token = config('services.documanage_api.token');

        $client = Http::baseUrl($baseUrl)
            ->acceptJson();

        if (!empty($token)) {
            $client = $client->withToken($token);
        }

        return $client;
    }

    /**
     * Fetch all clients with optional search query.
     *
     * @param string|null $q
     * @return array
     */
    public function index(?string $q = null)
    {
        try {
            $response = $this->client()->get('/api/clients', [
                'q' => $q
            ]);

            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }

            Log::error('API Error: ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('API Connection Exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Store a new client.
     *
     * @param array $payload
     * @return array
     */
    public function store(array $payload)
    {
        try {
            $response = $this->client()->post('/api/clients', $payload);

            if ($response->successful()) {
                // Ensure we return the data part
                return $response->json()['data'] ?? $response->json();
            }

            // Extract the first validation error if it's a 422
            if ($response->status() === 422 && isset($response->json()['errors'])) {
                $firstError = collect($response->json()['errors'])->flatten()->first();
                if ($firstError) {
                    throw new \Exception($firstError);
                }
            }

            Log::error('API Store Error: ' . $response->body());
            throw new \Exception($response->json()['message'] ?? 'Unable to create client.');
        } catch (\Exception $e) {
            Log::error('API Connection Exception: ' . $e->getMessage());
            throw $e;
        }
    }
}
