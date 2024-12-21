<?php

/**
 * This is the class to generate all the
 * permissions for Coinbase in order to connect a user
 * to your application.
 *
 * @author Refaltor
 */

namespace refaltor\coinbase\scopes;

class Permissions
{
    const SCOPE_WALLET_ACCOUNTS_READ = 'wallet:accounts:read';
    const SCOPE_WALLET_ADDRESSES_READ = 'wallet:addresses:read';
    const SCOPE_WALLET_TRANSACTIONS_READ = 'wallet:transactions:read';
    const SCOPE_WALLET_TRANSACTIONS_SEND = 'wallet:transactions:send';
    const SCOPE_WALLET_ORDERS_READ = 'wallet:orders:read';
    const SCOPE_WALLET_ORDERS_CREATE = 'wallet:orders:create';
    const SCOPE_WALLET_ORDERS_CANCEL = 'wallet:orders:cancel';
    const SCOPE_WALLET_BALANCES_READ = 'wallet:balances:read';
    const SCOPE_WALLET_PROFILE_READ = 'wallet:profile:read';
    const SCOPE_WALLET_PAYMENT_METHODS_READ = 'wallet:payment-methods:read';
    const SCOPE_WALLET_PAYMENT_METHODS_ADD = 'wallet:payment-methods:add';
    const SCOPE_WALLET_PAYMENT_METHODS_DELETE = 'wallet:payment-methods:delete';
    const SCOPE_WALLET_ADDRESSES_CREATE = 'wallet:addresses:create';
    const SCOPE_WALLET_TRANSACTIONS_CREATE = 'wallet:transactions:create';
    const SCOPE_EMAIL = 'email';
    const SCOPE_PROFILE = 'profile';
    const SCOPE_OPEN_ID = 'open_id';

    private $scopes = [];

    public static function create(): Permissions
    {
        return new self();
    }

    public function addScope(string $scope): void
    {
        $this->scopes[] = $scope;
    }

    public function removeScope(string $scope): void
    {
        $key = array_search($scope, $this->scopes);
        if ($key !== false) {
            unset($this->scopes[$key]);
        }
    }

    public function getScopesAsString(): string
    {
        return implode(' ', $this->scopes);
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }
}