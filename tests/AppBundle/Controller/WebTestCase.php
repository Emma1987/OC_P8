<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;

class WebTestCase extends BaseWebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \AppBundle\Entity\User
     */
    protected $user;

    /**
     * @var \AppBundle\Entity\Task
     */
    protected $task;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        self::bootKernel();
        $this->entityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function loadUserForTests()
    {
        $this->entityManager->createQuery('DELETE AppBundle:User u')->execute();

        $user = new User();

        $user->setUsername('Username');
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, 'pass_1234');
        $user->setPassword($encoded);
        $user->setEmail('email@example.com');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->user = $user;
    }

    public function loadTaskForTests()
    {
        $this->entityManager->createQuery('DELETE AppBundle:Task t')->execute();

        $task = new Task();
        $task->setTitle('Un titre de test');
        $task->setContent('Une description');
        $task->setCreatedAt(new \Datetime('2018-05-25 12:00:00'));
        $task->toggle(false);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        $this->task = $task;
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;

        $this->user = null;
        $this->task = null;
    }
}