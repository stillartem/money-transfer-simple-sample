<?php

namespace App\Domain\Payments\Entity;

use App\Domain\Core\Entity\User;
use App\Domain\Core\ValueObject\CurrencyCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="wallet",
 *  indexes={
 *          @ORM\Index(name="wallet_rule_id", columns={"rule_id"})
 *  }
 * )
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
     * @var Rule
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Payments\Entity\Rule", cascade={"all"})
     *
     */
    private $rule;

    /**
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Core\Entity\User", inversedBy="wallets", cascade={"persist"})
     */
    private $user;

    public function __construct()
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTime();
        }
    }

    /**
     * @param string $name
     * @return Wallet
     */
    public function setName(string $name): Wallet
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param CurrencyCode $currencyCode
     * @return Wallet
     */
    public function setCurrencyCode(CurrencyCode $currencyCode): Wallet
    {
        $this->currencyCode = (string)$currencyCode;
        return $this;
    }

    /**
     * @return CurrencyCode
     */
    public function getCurrencyCode(): CurrencyCode
    {
        return CurrencyCode::fromString($this->currencyCode);
    }

    /**
     * @param User $user
     * @return Wallet
     */
    public function setUser(User $user): Wallet
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isUserWallet(User $user)
    {
        return $this->user->getEmail() === $user->getEmail();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param Rule $rule
     * @return Wallet
     */
    public function setRule(Rule $rule): Wallet
    {
        $this->rule = $rule;
        return $this;
    }

    /**
     * @return Rule
     */
    public function getRule(): Rule
    {
        return $this->rule;
    }
}