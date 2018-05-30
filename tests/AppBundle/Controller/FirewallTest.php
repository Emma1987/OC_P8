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

    /**
     * @dataProvider urlWithRoleAnonymousProvider
     */
    public function testRoutesWhichNeedRoleAnonymousAreNotRedirected($url)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlWithRoleAnonymousProvider()
    {
        return [
            ['/login'],
            ['/users'],
            ['/users/create']
        ];
    }

    public function testUserEditRouteIsNotRedirected()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users/'.$this->user->getId().'/edit');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @dataProvider urlWithRoleUserProvider
     */
    public function testRoutesRequiringAuthentication($url)
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

	/**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}