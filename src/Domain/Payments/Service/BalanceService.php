<?php

namespace App\Domain\Payments\Service;

use App\Domain\Payments\Dto\BalanceDto;
use App\Domain\Payments\Entity\Wallet;
use App\Domain\Payments\Repository\TransactionRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class BalanceService
{
    /** @var TransactionRepository */
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param Wallet $wallet
     * @return BalanceDto
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getBalanceForWallet(Wallet $wallet)
    {
        return new BalanceDto(
            $this->transactionRepository->getBalance($wallet),
            $wallet->getId(),
            $wallet->getUser()->getId()
        );
    }
}