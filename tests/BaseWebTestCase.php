<?php

namespace App\Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelInterface;

class BaseWebTestCase extends WebTestCase
{
    /** @var EntityManager */
    private $entityManager;

    /** @var KernelBrowser */
    private static $client;


    protected function setUp(): void
    {
        parent::setUp();

        self::getWebClient();
        self::bootKernel(['force' => true]);

        $this->entityManager = $this->getEntityManager();
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        if ($this->entityManager) {
            $this->entityManager->clear(); // avoid memory leaks
            $this->entityManager = null;
        }
        self::$client = null;
    }


    /**
     * @param array $options
     *
     * @return KernelInterface
     */
    protected static function bootKernel(array $options = [])
    {
        return (array_key_exists('force', $options) && $options['force']) || !static::$kernel
            ? parent::bootKernel($options)
            : static::$kernel;
    }


    /**
     * @return EntityManager
     */
    protected function getEntityManager(): EntityManager
    {
        if (!$this->entityManager) {
            $this->entityManager = self::$container->get('doctrine')->getManager();
        }

        return $this->entityManager;
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }


    protected static function purgeDatabase(): void
    {
        $manager = self::bootKernel()->getContainer()->get('doctrine')->getManager();

        $purger = new ORMPurger($manager);
        // $purger->setPurgeMode($purger::PURGE_MODE_TRUNCATE);
        $purger->purge();
        self::purgeJsonFiles();
    }

    public static function purgeJsonFiles()
    {
        $di = new RecursiveDirectoryIterator(
            self::$container->getParameter('path_to_customer_storage'), FilesystemIterator::SKIP_DOTS
        );
        $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($ri as $file) {
            $file->isDir() ? rmdir($file) : unlink($file);
        }

        return true;
    }

    /**
     * @param $object
     */
    protected function save($object)
    {
        try {
            $this->getEntityManager()->persist($object);
            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            $this->fail('Can\'t save entity ' . get_class($object) . ': ' . $e->getMessage());
        }
    }


    /**
     * @param bool $recreateKernel
     *
     * @return KernelBrowser
     */
    protected static function getWebClient($recreateKernel = false): KernelBrowser
    {
        if (!self::$client) {
            self::$client = static::createClient(
                [
                    'environment' => 'test',
                    'debug' => true,
                    'force' => false,
                ]
            );
        }

        return self::$client;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $jsonBody
     *
     * @param string|null $authToken
     * @return array
     */
    protected function request(string $method, string $url, array $jsonBody = [], string $authToken = null): array
    {
        $content = $jsonBody ? json_encode($jsonBody) : null;
        $headers = [
            'HTTP_Authorization' => 'Bearer '. $authToken
        ];
        self::getWebClient()->request($method, $url, [], [], $headers, $content);
        $response = self::getWebClient()->getResponse();
        $this->assertInstanceOf(JsonResponse::class, $response);
        return json_decode($response->getContent(), true);
    }
}