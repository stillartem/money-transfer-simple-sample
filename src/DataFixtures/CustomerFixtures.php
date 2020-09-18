<?php

namespace App\DataFixtures;

use App\Domain\Core\Entity\User;
use App\Domain\Core\ValueObject\CurrencyCode;
use App\Domain\Payments\Entity\Rule;
use App\Domain\Payments\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerFixtures extends Fixture
{
    public const CARLOS_REFERENCE = 'carlos@test.com';

    public const HUAN_REFERENCE = 'huan@test.com';

    /** @var UserPassword`EncoderInterface */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        $usersList = $this->getUsers();
        foreach ($usersList as $item) {
            $user = (new User())
                ->setEmail($item['email']);

            if ($item['reference'] === true) {
                $this->addReference($item['email'], $user);
            }
            $user->setPassword($this->passwordEncoder->encodePassword($user, $item['password']));
            foreach ($item['wallet'] as $code => $values) {
                $wallet = $this->getWallet($code, $values['name'], $user);
                $user->addWallet($wallet);
            }
            $manager->persist($user);
        }
        $manager->flush();
    }

    /**
     * @return array
     */
    private function getUsers(): array
    {
        return [
            [
                'email' => 'admin@test.com',
                'reference' => false,
                'password' => 'test',
                'wallet' => [
                    Wallet::BTC_CODE => [
                        'name' => 'BTC wallet',
                    ],
                    Wallet::ETH_CODE => [
                        'name' => 'ETH wallet',
                    ],
                ]
            ],
            [
                'email' => self::CARLOS_REFERENCE,
                'reference' => true,
                'password' => 'test',
                'wallet' => [
                    Wallet::BTC_CODE => [
                        'name' => 'BTC wallet',
                    ],
                    Wallet::ETH_CODE => [
                        'name' => 'ETH wallet'
                    ],
                ]
            ],
            [
                'email' => self::HUAN_REFERENCE,
                'reference' => true,
                'password' => 'test',
                'wallet' => [
                    Wallet::ETH_CODE => [
                        'name' => 'ETH wallet'
                    ],
                ]

            ],
            [
                'email' => 'alberto@test.com',
                'reference' => false,
                'password' => 'test',
                'wallet' => [
                    Wallet::BTC_CODE => [
                        'name' => 'BTC wallet',
                    ],
                ]

            ],
            [
                'reference' => false,
                'email' => 'rodriges@test.com',
                'password' => 'test',
                'wallet' => []
            ]
        ];
    }

    private function getRule()
    {
        return (new Rule())
            ->setCommission(0.015)
            ->setMaxTransferAmount(500)
            ->setMinTransferAmount(1);
    }

    private function getWallet(string $code, string $name, User $user)
    {
        return (new Wallet())
            ->setCurrencyCode(CurrencyCode::fromString($code))
            ->setName($name)
            ->setRule($this->getRule())
            ->setUser($user);
    }
}