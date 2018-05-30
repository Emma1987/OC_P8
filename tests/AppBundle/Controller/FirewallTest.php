<?php

namespace Tests\AppBundle\Controller;

class FirewallTest extends WebTestCase
{
	private $client;

	/**
     * {@inheritDoc}
     */
	public function setUp()
	{
		parent::setUp();

        $this->client = static::createClient();

        $this->loadFixturesForTests();
	}

    // ROUTES ACCESSIBLES TO ANONYMOUS
    
    public function testLoginRouteIsAccessibleToAnonymous()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    // ROUTES ACCESSIBLE TO ROLE USER

    /**
     * @dataProvider urlWithRoleUserProvider
     */
    public function testRoutesRequiringRoleUser($url)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));
    }

    public function urlWithRoleUserProvider()
    {
        return [
            ['/'],
            ['/tasks'],
            ['/tasks/create']
        ];
    }

    public function testEditTaskRouteIsRedirected()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks/'.$this->task->getId().'/edit');
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));
    }

    public function testToggleTaskRouteIsRedirected()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks/'.$this->task->getId().'/toggle');
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));
    }

    public function testDeleteTaskRouteIsRedirected()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks/'.$this->task->getId().'/delete');
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));
    }

    // ROUTES ACCESSIBLE TO ROLE ADMIN
    
    public function testUserEditRouteIsAccessibleToRoleAdmin()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Admin',
            'PHP_AUTH_PW'   => 'pass_1234',
        ));

        $crawler = $client->request('GET', '/users/'.$this->user->getId().'/edit');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

	/**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}