<?php

/**
 * Helper trait to interact with Coinbase's
 * connection methods.
 *
 * @author Refaltor
 */

namespace refaltor\coinbase\helpers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory;
use refaltor\coinbase\data\CoinbaseAccess;
use refaltor\coinbase\exceptions\CoinbaseCreateTokenException;
use refaltor\coinbase\exceptions\CoinbaseRefreshTokenException;
use refaltor\coinbase\scopes\Permissions;

trait CoinbaseAuth
{
    /**
     * Function to get the URL that will send your
     * user to Coinbase to accept the
     * terms of your application.
     */
    public function getConnectionUrl(Permissions $permissions): string
    {
        $loginUrl = self::COINBASE_LOGIN_URL;

        $scopesString = $permissions->getScopesAsString();

        $parameters = [
            'response_type' => 'code',
            'client_id' => $this->getClientId(),
            'redirect_uri' => $this->getRedirectUri(),
            'scope' => $scopesString
        ];

        $queryString = http_build_query($parameters);
        return $loginUrl . '?' . $queryString;
    }

    /**
     * Function for create first token with code
     * generated by coinbase authorization page.
     *
     * @throws ConnectionException
     * @throws CoinbaseCreateTokenException
     */
    public function saveTokenWithAccessCode(string $code): CoinbaseAccess
    {
        $http = new Factory();
        $tokenUrl = self::COINBASE_TOKEN_URL;
        $parameters = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'code' => $code,
            'redirect_uri' => $this->getRedirectUri()
        ];

        $response = $http->asForm()->post($tokenUrl, $parameters);

        if ($response->failed()) {
            throw new CoinbaseCreateTokenException("Unable to create token : " . $response->reason());
        }

        $json = $response->json();
        $access = new CoinbaseAccess($json['access_token'], $json['refresh_token'], $json['expires_in']);
        $this->setCoinbaseAccess($access);
        return $access;
    }

    /**
     * Function to refresh a token in order
     * to continue using the Coinbase API.
     *
     * @throws CoinbaseRefreshTokenException
     * @throws ConnectionException
     */
    public function refreshToken(CoinbaseAccess $access): CoinbaseAccess
    {
        $http = new Factory();
        $tokenUrl = self::COINBASE_TOKEN_URL;
        $parameters = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'refresh_token' => $access->getRefreshToken()
        ];

        $response = $http->asForm()->post($tokenUrl, $parameters);
        if ($response->failed()) {
            throw new CoinbaseRefreshTokenException("Refresh token failed with error: " . $response->reason());
        }

        $data = $response->json();
        $accessToken = $data['access_token'];
        $refreshToken = $data['refresh_token'];
        $expiresIn = $data['expires_in'];

        $access =  new CoinbaseAccess($accessToken, $refreshToken, $expiresIn);
        $this->setCoinbaseAccess($access);
        return $access;
    }

    /**
     * Function for revoke Coinbase
     * access token.
     */
    public function revokeToken(CoinbaseAccess $access): bool
    {
        $http = new Factory();
        $tokenRevokeUrl = self::COINBASE_TOKEN_REVOKE_URL;
        $parameters = [
            'token' => $access->getAccessToken(),
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret()
        ];

        $response = $http->asForm()->post($tokenRevokeUrl, $parameters);

        $this->setCoinbaseAccess(null);
        return $response->successful();
    }
}
