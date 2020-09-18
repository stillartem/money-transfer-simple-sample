<?php

namespace App\Domain\Payments\Dto;

use App\Domain\Core\Dto\Dto;

class BalanceDto implements Dto
{
    /** @var float */
    private $balance;
    /** @var int */
    private $walletId;
    /** @var int */
    private $userId;

    public function __construct(float $balance, int $walletId, int $userId)
    {
        $this->balance = $balance;
        $this->walletId = $walletId;
        $this->userId = $userId;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return [
            'balance' => $this->balance,
            'wallet-id' => $this->walletId,
            'user-id' => $this->userId
        ];
    }
}