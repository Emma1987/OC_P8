<?php

namespace Tests\AppBundle\Controller;

class UserControllerTest extends WebTestCase
{
    private $client;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
        
        $this->loadUserForTests();
    }

    public function testCreateNewUser()
    {
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $crawler = $this->client->submit($form, array(
            'user[username]'         => 'OtherUsername',
            'user[password][first]'  => 'password',
            'user[password][second]' => 'password',
            'user[email]'            => 'other_email@example.com'
        ));

        $crawler = $this->client->followRedirect();

        $this->assertContains('L\'utilisateur a bien été ajouté.', $crawler->filter('div.alert-success')->text());

        $user = $this->entityManager->getRepository('AppBundle:User')->findByUsername('OtherUsername');
        $this->assertCount(1, $user);
    }

    public function testEditUser()
    {
        $crawler = $this->client->request('GET', '/users/'.$this->user->getId().'/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $crawler = $this->client->submit($form, array(
            'user[username]' => 'NewUsername'
        ));

        $crawler = $this->client->followRedirect();

        $this->assertContains('Superbe ! L\'utilisateur a bien été modifié', $crawler->filter('div.alert-success')->text());

        $this->entityManager->refresh($this->user);
        $this->assertSame('NewUsername', $this->user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}