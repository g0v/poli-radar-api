<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventsTest extends TestCase
{
    private $token;

    public function setUp()
    {
        parent::setUp();
        $response = $this->call('POST', '/api/login', [
            'email' => 'renddi@relab.cc',
            'password' => 'renddi',
        ]);
        $this->token = json_decode($response->content(), true)['token'];
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetEventList()
    {
        $this->get('/api/events')
            ->seeJson(['name' => '紅包發放拜年行程']);
    }

    public function testGetEventListIncludingPersons()
    {
        $this->get('/api/events?include=persons')
            ->seeJson(['name' => '洪慈庸']);
    }
}
