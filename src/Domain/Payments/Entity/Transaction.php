<?php

namespace App\Domain\Payments\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="transaction",
 *
 *  indexes={
 *          @ORM\Index(name="transaction_wallet_id", columns={"wallet_id"})
 *  }
 * )
 */
class Transaction
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Wallet
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Payments\Entity\Wallet", cascade={"all"})
     *
     */
    private $wallet;


    /**
     * @var TransactionInitiator
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Payments\Entity\TransactionInitiator", cascade={"all"})
     *
     */
    private $transactionInitiator;

    /**
     * @var string
     *
     * @ORM\Column(type="float", nullable=false)
     */
    private $amount;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTime();
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Wallet $wallet
     * @return Transaction
     */
    public function setWallet(Wallet $wallet)
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * @return Wallet
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param TransactionInitiator $transactionInitiator
     * @return Transaction
     */
    public function setTransactionInitiator(TransactionInitiator $transactionInitiator)
    {
        $this->transactionInitiator = $transactionInitiator;

        return $this;
    }

    /**
     * @return TransactionInitiator
     */
    public function getTransactionInitiator()
    {
        return $this->transactionInitiator;
    }

    /**
     * @param string $amount
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }
}