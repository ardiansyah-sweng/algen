<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class UserAgentTest extends TestCase
{
    private $http;

    public function test_setup()
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'https://uad.ac.id']);
        $res = $this->http->request('GET', '/');
        print_r($res->getBody());
    }

    public function testGet()
    {

        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], 'Hello, World'),
            new Response(202, ['Content-Length' => 0]),
            new RequestException('Error Communicating with Server', new Request('GET', 'test'))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        // The first request is intercepted with the first response.
        $response = $client->request('GET', '/');
        echo "\n";
        echo $response->getStatusCode();
        echo "\n";
        //> 200
        echo $response->getBody();
        //> Hello, World
        // The second request is intercepted with the second response.
        echo "\n";
        echo $client->request('GET', '/')->getStatusCode();
        //> 202

        // Reset the queue and queue up a new response
        $mock->reset();
        $mock->append(new Response(201));

        // As the mock was reset, the new response is the 201 CREATED,
        // instead of the previously queued RequestException
        echo "\n";
        echo $client->request('GET', '/')->getStatusCode();
        //> 201    
    }

    // public function tearDown()
    // {
    //     $this->http = null;
    // }
}
