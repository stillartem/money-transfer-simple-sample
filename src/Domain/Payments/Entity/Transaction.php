<?php

namespace App\Domain\Payments\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Payments\Repository\TransactionRepository")
 * @ORM\Table(name="transaction",
 *  indexes={
 *          @ORM\Index(name="transaction_wallet_id", columns={"wallet_id"})
 *  }
 * )
 */
class Transaction
{
    public const TYPE_COMMISSION = 'commission';
    public const TYPE_TRANSFER = 'transfer';

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
     * @var float
     *
     * @ORM\Column(type="float", nullable=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $type;

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
     * @param float $amount
     * @return Transaction
     */
    public function setAmount(float $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Transaction
     */
    public function setType(string $type): Transaction
    {
        $this->type = $type;
        return $this;
    }
}