<?php


namespace App\Domain\Payments\Repository;

use App\Domain\Payments\Entity\Transaction;
use App\Domain\Payments\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class TransactionRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * @param Transaction $transaction
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Transaction $transaction): void
    {
        $this->_em->persist($transaction);
        $this->_em->flush();
    }

    /**
     * @param Wallet $wallet
     * @return float
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getBalance(Wallet $wallet)
    {
        return (float)$this->createQueryBuilder('b')
            ->andWhere('b.wallet = :wallet')
            ->setParameter('wallet', $wallet)
            ->select('SUM(b.amount) as balance')
            ->getQuery()
            ->getSingleScalarResult();
    }
}