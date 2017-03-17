<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends TestCase
{
    private $testUsername = 'foobar';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->post('/api/login', [
            'email' => 'renddi@relab.cc',
            'password' => 'renddi',
        ])->seeJson(['roles' => ['admin']]);
    }

    public function testToken()
    {
        $response = $this->call('POST', '/api/login', [
            'email' => 'renddi@relab.cc',
            'password' => 'renddi',
        ]);
        $token = json_decode($response->content(), true)['token'];
        $this->post('/api/persons', [
            'name' => $this->testUsername,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ])->seeJson(['name' => $this->testUsername]);
    }

    public function tearDown()
    {
        User::where('name', '=', $this->testUsername)->delete();
    }

}
