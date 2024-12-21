<?php

/**
 * Class for crypto account in coinbase (like wallet).
 *
 * @author Refaltor
 */

namespace refaltor\coinbase\modules\accounts;

use Carbon\Carbon;

readonly class Account
{
    public function __construct
    (
        private string $id,
        private string $name,
        private bool   $primary,
        private string $addressRegex,
        private string $assetId,
        private string $code,
        private string $color,
        private int    $exponent,
        private string $coinName,
        private string $type,
        private float  $walletBalanceAmount,
        private string $currencyName,
        private Carbon $createdAt,
        private Carbon $updatedAt,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isPrimary(): bool
    {
        return $this->primary;
    }

    public function getAddressRegex(): string
    {
        return $this->addressRegex;
    }

    public function getAssetId(): string
    {
        return $this->assetId;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getExponent(): int
    {
        return $this->exponent;
    }

    public function getCoinName(): string
    {
        return $this->coinName;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getWalletBalanceAmount(): float
    {
        return $this->walletBalanceAmount;
    }

    public function getCurrencyName(): string
    {
        return $this->currencyName;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }
}