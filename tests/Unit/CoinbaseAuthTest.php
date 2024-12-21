<?php

require "vendor/autoload.php";

use refaltor\coinbase\Coinbase;
use refaltor\coinbase\scopes\Permissions;

test('test create url auth coinbase', function ()
{
    $coinbase = Coinbase::create(
        '',
        '',
        'http://localhost:8001/integrations/cb/callback'
    );


    $permissions = Permissions::create();
    $permissions->addScope(Permissions::SCOPE_WALLET_ACCOUNTS_READ);
    $permissions->addScope(Permissions::SCOPE_WALLET_TRANSACTIONS_READ);
    $urlAuth = $coinbase->getConnectionUrl($permissions);
    var_dump($urlAuth);

    $code = "ZhJqg8BYT1UGUkLPrsO9lVJ-Cx0qIkbSfdgy45nLEsA.N1vN9T4fKh0fnkd5UT7wrQjbTaBhJF0Iz4sibOOy_nk";
    $access = $coinbase->saveTokenWithAccessCode($code);
    var_dump($access);

    expect($urlAuth)->toBe("https://login.coinbase.com/oauth2/auth?response_type=code&client_id=f5971d0b-e22f-444f-97f0-f2f86ded5bb9&redirect_uri=http%3A%2F%2Flocalhost%3A8001%2Fintegrations%2Fcb%2Fcallback&scope=wallet%3Aaccounts%3Aread+wallet%3Atransactions%3Aread");
});