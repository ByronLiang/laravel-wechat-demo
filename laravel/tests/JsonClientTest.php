<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JsonClientTest extends TestCase
{
    private $client;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = new \Ganguo\JSend\JsonClient([
            'base_uri' => 'http://httpbin.org'
        ]);
    }

    public function testGet()
    {
        $res = $this->client->get('get', [
            'query' => [
                'test' => 'test'
            ]
        ]);

        $this->assertObjectHasAttribute('origin', $res);
    }

    public function testPostJson()
    {
        $res = $this->client->post('post', [
            'query' => [
                'test' => 'test'
            ]
        ]);

        $this->assertObjectHasAttribute('origin', $res);
    }
    public function testPostForm()
    {
        $res = $this->client->post('post', [
            'form_params' => [
                'test' => 'test'
            ],
        ]);

        $this->assertObjectHasAttribute('origin', $res);
    }

    public function testGetArray()
    {
        $this->client->switchArray();
        $res = $this->client->get('get');

        $this->assertArrayHasKey('origin', $res);
    }
}
