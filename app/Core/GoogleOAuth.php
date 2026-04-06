<?php
declare(strict_types=1);

namespace App\Core;

use Google\Client;
use Google\Service\Oauth2;
use RuntimeException;

final class GoogleOAuth
{
    public function __construct(private readonly array $config)
    {
    }

    public function createAuthUrl(string $state): string
    {
        $client = $this->client();
        $client->setState($state);

        return $client->createAuthUrl();
    }

    public function fetchUser(string $code): array
    {
        $client = $this->client();
        $token = $client->fetchAccessTokenWithAuthCode($code);

        if (isset($token['error'])) {
            throw new RuntimeException((string) ($token['error_description'] ?? $token['error']));
        }

        $client->setAccessToken($token);
        $oauth = new Oauth2($client);
        $profile = $oauth->userinfo->get();

        return [
            'name' => (string) $profile->name,
            'email' => strtolower((string) $profile->email),
            'avatar' => (string) $profile->picture,
        ];
    }

    private function client(): Client
    {
        $client = new Client();
        $client->setClientId((string) ($this->config['client_id'] ?? ''));
        $client->setClientSecret((string) ($this->config['client_secret'] ?? ''));
        $client->setRedirectUri((string) ($this->config['redirect_uri'] ?? ''));
        $client->setAccessType('online');
        $client->setPrompt('select_account');
        $client->addScope('email');
        $client->addScope('profile');

        $hostedDomain = (string) ($this->config['hosted_domain'] ?? '');
        if ($hostedDomain !== '') {
            $client->setHostedDomain($hostedDomain);
        }

        return $client;
    }
}