<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service class for interacting with the Fonnte WhatsApp API.
 */
class FonnteService
{
    protected $token;
    protected $endpoint;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
        $this->endpoint = 'https://api.fonnte.com/send';
    }

    /**
     * Sends a WhatsApp message to a specified phone number.
     *
     * @param string $phone The recipient's phone number.
     * @param string $message The message content.
     * @return array An array containing the status and body of the response.
     */
    public function send(string $phone, string $message): array
    {
        if (!$this->token) {
            Log::error('Fonnte Error: FONNTE_TOKEN is not set.');
            return ['ok' => false, 'status' => 500, 'body' => 'Token Fonnte tidak diatur.'];
        }

        $normalizedPhone = $this->normalizePhoneNumber($phone);

        try {
            $response = Http::asForm()->withHeaders([
                'Authorization' => $this->token,
            ])->withOptions(['verify' => false])->post($this->endpoint, [
                'target' => $normalizedPhone,
                'message' => $message,
            ]);

            if (!$response->successful()) {
                Log::error('Fonnte API Error', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
            }

            return [
                'ok' => $response->successful(),
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
            ];
        } catch (\Exception $e) {
            Log::error('Fonnte Request Exception', ['error' => $e->getMessage()]);
            return ['ok' => false, 'status' => 500, 'body' => $e->getMessage()];
        }
    }

    /**
     * Normalizes a phone number to the international format required by Fonnte.
     *
     * @param string $phone The phone number to normalize.
     * @return string The normalized phone number.
     */
    private function normalizePhoneNumber(string $phone): string
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If the number starts with '0', replace it with '62'
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }
}
