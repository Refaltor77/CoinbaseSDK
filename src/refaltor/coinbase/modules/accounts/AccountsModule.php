<?php

namespace refaltor\coinbase\modules\accounts;

use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use refaltor\coinbase\exceptions\CoinbaseAccountGetException;

trait AccountsModule
{
    /**
     * Function for get all accounts in
     * coinbase connected user.
     *
     * @return Account[]
     * @throws ConnectionException
     * @throws CoinbaseAccountGetException
     */
    public function getAccounts(): array
    {
        $access = $this->getCoinbaseAccess();
        $accounts = [];

        $apiUrl = self::COINBASE_API_BASE_URL . 'accounts';
        $pendingRequest = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $access->getAccessToken(),
        ]);

        $response = $pendingRequest->get($apiUrl);
        if (!$response->failed()) {
            throw new CoinbaseAccountGetException(
                "Unable to retrieve accounts : " . $response->reason(),
                $response->getStatusCode()
            );
        }

        $requestData = $response->json()['data'];
        foreach ($requestData as $accountArray) {
            $accounts[] = new Account(
                $accountArray['id'],
                $accountArray['name'],
                $accountArray['primary'],
                $accountArray['currency']['address_regex'],
                $accountArray['currency']['asset_id'],
                $accountArray['currency']['code'],
                $accountArray['currency']['color'],
                $accountArray['currency']['exponent'],
                $accountArray['currency']['name'],
                $accountArray['currency']['type'],
                $accountArray['balance']['amount'],
                $accountArray['balance']['currency'],
                Carbon::parse($accountArray['created_at']),
                Carbon::parse($accountArray['updated_at']),
            );
        }

        return $accounts;
    }
}