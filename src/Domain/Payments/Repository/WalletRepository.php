<?php

namespace App\Domain\Payments\Repository;

use App\Domain\Payments\Entity\Rule;
use App\Domain\Payments\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class WalletRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    /**
     * @param string $walletId
     * @return object|Wallet|null
     */
    public function getUserWallet(string $walletId)
    {
        return $this->findOneBy(
            [
                'id' => (int)$walletId,
            ]
        );
    }

    /**
     * @param Wallet $wallet
     * @return Rule
     */
    public function getRuleForWallet(Wallet $wallet)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.wallet = :wallet')
            ->setParameter('wallet', $wallet)
            ->select('w.rule')
            ->getQuery()
            ->getResult();
    }


    /**
     * @param Wallet $authToken
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Wallet $authToken): void
    {
        $this->_em->persist($authToken);
        $this->_em->flush();
    }
}