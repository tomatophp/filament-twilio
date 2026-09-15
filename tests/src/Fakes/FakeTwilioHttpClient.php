<?php

namespace TomatoPHP\FilamentTwilio\Tests\Fakes;

use Twilio\AuthStrategy\AuthStrategy;
use Twilio\Http\Client;
use Twilio\Http\Response;

/**
 * Records every request the Twilio SDK makes instead of calling the Twilio API.
 */
class FakeTwilioHttpClient implements Client
{
    /**
     * @var array<int, array{method: string, url: string, data: array<string, mixed>, user: ?string}>
     */
    public array $requests = [];

    public function request(
        string $method,
        string $url,
        array $params = [],
        array $data = [],
        array $headers = [],
        ?string $user = null,
        ?string $password = null,
        ?int $timeout = null,
        ?AuthStrategy $authStrategy = null
    ): Response {
        $this->requests[] = [
            'method' => $method,
            'url' => $url,
            'data' => $data,
            'user' => $user,
        ];

        return new Response(201, json_encode([
            'sid' => 'SM' . str_pad((string) count($this->requests), 32, '0', STR_PAD_LEFT),
            'status' => 'queued',
            'to' => $data['To'] ?? null,
            'from' => $data['From'] ?? null,
            'body' => $data['Body'] ?? null,
        ]));
    }
}
