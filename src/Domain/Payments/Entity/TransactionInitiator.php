<?php

namespace App\Domain\Payments\Entity;

use App\Domain\Core\Entity\User;


/**
 * @ORM\Entity
 * @ORM\Table(name="transaction_initiator")
 */
class TransactionInitiator
{

    public const OPERATION_TYPE_TRANSFER = 'transfer';
    public const OPERATION_TYPE_DEPOSIT = 'deposit';

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
     * @ORM\ManyToOne(targetEntity="App\Domain\Core\Entity\User", inversedBy="wallets", cascade={"persist"})
     */
    private $initiator;

}