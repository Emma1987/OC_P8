<?php

namespace Tests\AppBundle\Controller;

class TaskControllerTest extends WebTestCase
{
    private $client;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Username',
            'PHP_AUTH_PW'   => 'pass_1234',
        ));

        $this->loadTaskForTests();
    }

    public function testCreateNewTask()
    {
        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Créer une nouvelle tâche')->link();
        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('Ajouter')->form();
        $crawler = $this->client->submit($form, array(
            'task[title]'   => 'Un titre de tâche',
            'task[content]' => 'La description de cette tâche',
        ));

        $crawler = $this->client->followRedirect();

        $this->assertContains('La tâche a été bien été ajoutée.', $crawler->filter('div.alert-success')->text());

        $task = $this->entityManager->getRepository('AppBundle:Task')->findByTitle('Un titre de tâche');
        $this->assertCount(1, $task);
    }

    public function testEditTask()
    {
        $crawler = $this->client->request('GET', '/tasks/'.$this->task->getId().'/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $crawler = $this->client->submit($form, array(
            'task[title]'   => 'Ce titre a été modifié'
        ));

        $crawler = $this->client->followRedirect();

        $this->assertContains('Superbe ! La tâche a bien été modifiée.', $crawler->filter('div.alert-success')->text());

        $this->entityManager->refresh($this->task);
        $this->assertSame('Ce titre a été modifié', $this->task->getTitle());
    }

    public function testToggleTask()
    {
        $crawler = $this->client->request('GET', '/tasks/'.$this->task->getId().'/toggle');
        $crawler = $this->client->followRedirect();

        $successMessage = 'Superbe ! La tâche '.$this->task->getTitle().' a bien été marquée comme faite.'; 
        $this->assertContains($successMessage, $crawler->filter('div.alert-success')->text());

        $this->entityManager->refresh($this->task);
        $this->assertTrue($this->task->isDone());
    }

    public function testDeleteTask()
    {
        $taskId = $this->task->getId();

        $crawler = $this->client->request('GET', '/tasks/'.$taskId.'/delete');
        $crawler = $this->client->followRedirect();

        $successMessage = 'Superbe ! La tâche a bien été supprimée.'; 
        $this->assertContains($successMessage, $crawler->filter('div.alert-success')->text());
        $this->entityManager->clear();
        $this->assertNull($this->entityManager->getRepository('AppBundle:Task')->find($taskId));
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}