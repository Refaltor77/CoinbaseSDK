<?php

namespace refaltor\coinbase\data;

class CoinbaseAccess
{
    private string $accessToken;
    private string $refreshToken;
    private int $refreshTokenExpireSeconds;

    public function __construct(string $accessToken, string $refreshToken, int $refreshTokenExpireSeconds)
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->refreshTokenExpireSeconds = time() + $refreshTokenExpireSeconds;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getRefreshTokenExpireSeconds(): int
    {
        return $this->refreshTokenExpireSeconds;
    }

    public function isTokenExpired(): bool
    {
        return $this->refreshTokenExpireSeconds < time();
    }
}