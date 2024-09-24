<?php

declare(strict_types=1);

namespace InvolveDigital\LaravelMailEcomail\Api;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class EcomailApiService
{

    public static function sendEmail(
        string $subject,
        string $nameFrom,
        string $emailFrom,
        string $content,
        string $emailTo,
        ?string $emailCopy = null,
        ?string $emailSecretCopy = null,
    ): PromiseInterface|Response|null
    {
        $paramTo = [
            'email' => $emailTo,
        ];

        if ($emailCopy) {
            $paramTo['cc'] = $emailCopy;
        }

        if ($emailSecretCopy) {
            $paramTo['bcc'] = $emailSecretCopy;
        }

        $body = [
            'message' => [
                'subject' => $subject,
                'from_name' => $nameFrom,
                'from_email' => $emailFrom,
                'html' => $content,
                'to' => [
                    $paramTo,
                ],
            ],
        ];

        return self::send($body);
    }

    /**
     * @throws ConnectionException
     */
    private static function send($body)
    {
        $url = config('laravel-mail-ecomail.send_mail_url');

        if (!$client = self::getBaseClient($body)) {
            return null;
        }

        $response = $client->post($url);

        if (!$response->ok()) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path(config('laravel-mail-ecomail.log_file')),
            ])->error([
                'email' => $body['message']['to'][0]['email'],
                'cc' => $body['message']['to'][0]['cc'] ?? '',
                'bcc' => $body['message']['to'][0]['bcc'] ?? '',
                'url' => $url,
                'error' => $response->body(),
            ]);
        }

        return $response;
    }

    private static function getBaseClient(array $body = []): ?PendingRequest
    {
        if (!$apiKey = config('laravel-mail-ecomail.api_key')) {
            return null;
        }

        $client = Http::withHeaders([
            'key' => $apiKey,
            'Content-Type' => 'application/json',
        ]);

        if ($body) {
            $client->withBody(json_encode($body));
        }

        return $client;
    }

}
