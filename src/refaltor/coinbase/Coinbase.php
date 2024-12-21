<?php

/**
 * Main class to start interacting with the Coinbase API,
 * this is where the connections are made
 * and token refreshes as well.
 *
 * @author Refaltor
 */


namespace refaltor\coinbase;

use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Facade;
use refaltor\coinbase\helpers\CoinbaseAuth;
use refaltor\coinbase\helpers\CoinbaseConnection;
use refaltor\coinbase\modules\accounts\AccountsModule;

class Coinbase
{
    use CoinbaseAuth;
    use CoinbaseConnection;

    # modules
    use AccountsModule;

    const COINBASE_LOGIN_URL = 'https://login.coinbase.com/oauth2/auth';
    const COINBASE_TOKEN_URL = 'https://login.coinbase.com/oauth2/token';
    const COINBASE_TOKEN_REVOKE_URL = 'https://login.coinbase.com/oauth2/revoke';
    const COINBASE_API_BASE_URL = 'https://api.coinbase.com/v2/';

    private string $clientID;
    private string $clientSecret;
    private string $redirectURI;

    public function __construct(string $clientID, string $clientSecret, string $redirectURI)
    {
        $this->clientID = $clientID;
        $this->redirectURI = $redirectURI;
        $this->clientSecret = $clientSecret;
    }

    public static function create(string $clientID, string $clientSecret, string $redirectURI): self
    {
        return new self($clientID, $clientSecret, $redirectURI);
    }

    public function getClientID(): string
    {
        return $this->clientID;
    }

    public function getRedirectURI(): string
    {
        return $this->redirectURI;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }
}