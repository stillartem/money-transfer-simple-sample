<?php

namespace App\Domain\Payments\Entity;

use App\Domain\Core\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="wallet")
 */
class Wallet
{

    public const ETH_CODE = 'eth';
    public const BTC_CODE = 'btc';

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
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $currencyCode;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     *
     * @var User[
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Payments\Entity\Wallet", inversedBy="wallets", cascade={"persist"})
     */
    private $user;
}