<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Trikoder\Bundle\OAuth2Bundle\Model\AccessToken;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;
use Trikoder\Bundle\OAuth2Bundle\Model\Grant;
use Trikoder\Bundle\OAuth2Bundle\Model\Scope;

class OAuthFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $grant = new Grant('password');
        $scope = new Scope('transfer');
        $id = '18b200eff471b7be6a0e509fcd23ced4';
        $client = (new Client(
            $id,
            'f7ba095db223ceef80df096da87cdfd3ba4457a2c30915d76333789e6981705754166d1faec216843178a5cc5a60aaf8576fa167611032fc03c7f7746bfb9d87'
        ))
            ->setActive(true)
            ->setGrants($grant)
            ->setScopes($scope);
        $manager->persist($client);
        $token = new AccessToken(
            '60761cdf309d88ba9c4bf7ea9dfd1b05ff965735ba5fd830788230c55cdda4feb5285b20302a2aae',
            \DateTimeImmutable::createFromMutable(new \DateTime('+15 weeks')),
            $client,
            null,
            [$scope]
        );

        $manager->persist($token);
        $manager->flush();
    }
}