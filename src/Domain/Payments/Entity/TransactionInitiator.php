<?php

namespace App\Domain\Payments\Entity;

use App\Domain\Core\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="transaction_initiator")
 * @ORM\HasLifecycleCallbacks()
 */
class TransactionInitiator
{

    public const OPERATION_TYPE_TRANSFER = 'transfer';
    public const OPERATION_TYPE_DEPOSIT = 'deposit';
    public const OPERATION_TYPE_WITHDRAWAL = 'withdrawal';

    public const STATUS_PENDING = 'pending';
    public const STATUS_NEW = 'new';
    public const STATUS_ERROR = 'error';
    public const STATUS_DONE = 'done';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $type;

    /**
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Core\Entity\User", cascade={"persist"})
     */
    private $initiator;

    /**
     *
     * @var User
     *
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="transactionInitiator", cascade={"persist"})
     */
    private $transactions;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTime();
        }

        if ($this->transactions === null) {
            $this->transactions = new ArrayCollection();
        }
    }

    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $status
     * @return TransactionInitiator
     */
    public function setStatus(string $status): TransactionInitiator
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
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
     * @return TransactionInitiator
     */
    public function setType(string $type): TransactionInitiator
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param User $initiator
     * @return TransactionInitiator
     */
    public function setInitiator(User $initiator): TransactionInitiator
    {
        $this->initiator = $initiator;
        return $this;
    }

    /**
     * @return User
     */
    public function getInitiator(): User
    {
        return $this->initiator;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
}