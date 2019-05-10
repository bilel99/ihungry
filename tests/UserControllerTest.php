<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    private $client;

    private $entityManager;

    private $repositoryUser;

    /**
     * PHPUNIT Framework
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();

        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->repositoryUser = $kernel->getContainer()
            ->get('doctrine')
            ->getRepository(User::class);
    }

    /**
     * @test
     * testing route
     * ("/login") => status 200
     */
    public function testRouteLoginIsSuccessfull()
    {
        $this->client->request('GET', '/login');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * @test
     */
    public function testRegistration()
    {
        $user = new User();
        $user->setName('Bekkouche');
        $user->setFirstname('Bilel');
        $user->setEmail('bilel.bekkouche@hotmail.fr');
        $user->setPassword('bilel');
        $user->setRoles(User::ROLE_USER);
        $user->setCreatedAt(new \DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $user = $this->repositoryUser
            ->findOneBy(['email' => 'bilel.bekkouche@hotmail.fr']);
        $nbrUser = $this->count($user);
        $this->assertEquals(1, $nbrUser);
    }




    /**
     * PHPUNIT Framework
     */
    public function tearDown()
    {
        parent::tearDown();

        // Remove user table
        $allUser = $this->repositoryUser->findAll();

        foreach ($allUser as $item) {
            $this->entityManager;
            $this->entityManager->remove($item);
            $this->entityManager->flush();
        }

        // Clean the entities manager
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
