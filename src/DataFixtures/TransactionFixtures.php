<?php

namespace App\DataFixtures;

use App\Domain\Core\Entity\User;
use App\Domain\Payments\Entity\Transaction;
use App\Domain\Payments\Entity\TransactionInitiator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TransactionFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var User $carlos */
        $carlos = $this->getReference(CustomerFixtures::CARLOS_REFERENCE);
        foreach ($carlos->getWallets() as $wallet) {
            $transactionInitiator = (new TransactionInitiator())
                ->setStatus(TransactionInitiator::STATUS_DONE)
                ->setType(TransactionInitiator::OPERATION_TYPE_DEPOSIT)
                ->setInitiator($carlos);

            $transaction = (new Transaction())
                ->setAmount(10000)
                ->setTransactionInitiator($transactionInitiator)
                ->setType(Transaction::TYPE_TRANSFER)
                ->setWallet($wallet);
            $manager->persist($transaction);
        }

        $manager->flush();
    }
}