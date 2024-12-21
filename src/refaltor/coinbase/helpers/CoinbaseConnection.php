<?php

/**
 * Class to cache the Coinbase access tokens.
 *
 * @author Refaltor
 */


namespace refaltor\coinbase\helpers;

use refaltor\coinbase\data\CoinbaseAccess;

trait CoinbaseConnection
{
    private static ?CoinbaseAccess $access = null;

    public function setCoinbaseAccess(?CoinbaseAccess $access): void
    {
        self::$access = $access;
    }

    public function getCoinbaseAccess(): ?CoinbaseAccess
    {
        return self::$access;
    }

    public function tokenIsValid(): bool
    {
        return $this->$this->getCoinbaseAccess()->isTokenExpired();
    }

    public function isCoinbaseLinked(): bool
    {
        return (!is_null($this->getCoinbaseAccess()));
    }
}