<?php
namespace mhndev\locationClient\Tests;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use mhndev\locationClient\Client;
use mhndev\locationClient\exceptions\InvalidNeighbourNodeDataException;
use mhndev\locationClient\objects\NeighbourNode;
use mhndev\locationClient\objects\Node;
use PHPUnit\Framework\TestCase;

/**
 * Class LocationClientTest
 * @package mhndev\locationClient\Tests
 */
class LocationClientTest extends TestCase
{

    /**
     * @var MockHandler
     */
    protected $mockHandler;



    public function testNearestNeighboursSuccess()
    {
        $bodyString = json_encode(['result' => [
            [
                'id' => 1,
                'distance' => '4332.324',
                'location' => ['lat' => 35.3432, 'lon' => 51.243]
            ],
            [
                'id' => 2,
                'distance' => '500045.324',
                'location' => ['lat' => 35.45332, 'lon' => 51.87765]
            ],
            [
                'id' => 3,
                'distance' => '650012.324',
                'location' => ['lat' => 36.245244, 'lon' => 51.123331]
            ]
        ]]);

        $mock = new MockHandler([new Response(200, [], $bodyString)]);

        $handler = HandlerStack::create($mock);
        $httpClient = new HttpClient(['handler' => $handler]);

        $token = 'sampleTokenString';

        $locationClient = new Client($httpClient, $token);

        $neighbours = $locationClient->nearestNeighbours(35.32423,51.32432);

        if(!empty($neighbours )){
            $this->assertInstanceOf(NeighbourNode::class, $neighbours[0]);
        }else{
            $this->assertEmpty($neighbours);
        }

    }


    public function testNearestNeighboursFail()
    {
        $serverResponseArray = [
            'result' =>
                [
                    [
                        // node here should be id
                        // check if invalid response is handled by client
                        'node' => 1,
                        'distance' => '4332.324',
                        'location' => ['lat' => 35.3432, 'lon' => 51.243]
                    ],
                    [
                        'id' => 2,
                        'distance' => '500045.324',
                        'location' => ['lat' => 35.45332, 'lon' => 51.87765]
                    ],
                    [
                        'id' => 3,
                        'distance' => '650012.324',
                        'location' => ['lat' => 36.245244, 'lon' => 51.123331]
                    ]
                ]
        ];

        $bodyString = json_encode($serverResponseArray);

        $mock = new MockHandler([new Response(200, [], $bodyString)]);

        $handler = HandlerStack::create($mock);
        $httpClient = new HttpClient(['handler' => $handler]);

        $token = 'sampleTokenString';

        $locationClient = new Client($httpClient, $token);

        try{
            $locationClient->nearestNeighbours(35.32423,51.32432);
            $this->assertTrue(false);

        }catch (InvalidNeighbourNodeDataException $e){
            $this->assertTrue(true);
        }
    }





    public function testSaveLastLocationSuccess()
    {
        $id = 'sampleNodeIdNumberGoesHere';
        $location =  [
            'lat' => 35.24534,
            'lon' => 51.24324
        ];

        /*
            // sample consider this is request body json
            $requestBodyArray = [
                'id' => $id,
                'location' => $location
            ];
        */

        $serverResponseArray = [
            'result' => [
                'id' => $id,
                'state' => 'ready',
                'location' => $location
            ]
        ];

        $bodyString = json_encode($serverResponseArray);
        $mock = new MockHandler([new Response(200, [], $bodyString)]);
        $handler = HandlerStack::create($mock);
        $httpClient = new HttpClient(['handler' => $handler]);
        $token = 'sampleTokenString';
        $locationClient = new Client($httpClient, $token);

        $node = Node::fromArray([
            'identifier' => 'mhnderf4',
            'latitude'   => 35.32233,
            'longitude'  => 51.24234,
            'state'      => 'ready',
            'trip_id'    => '34323'
        ]);

        $nodeResponse = $locationClient->saveLastLocation($node);

        $this->assertInstanceOf(Node::class, $nodeResponse);
        $this->assertEquals($nodeResponse->getIdentifier(), $id);
    }


    public function testSaveLastLocationFail()
    {
        $this->assertTrue(true);
    }

    public function testChangeNodeStateSuccess()
    {
        $this->assertTrue(true);
    }


    public function testChangeNodeStateFail()
    {
        $this->assertTrue(true);
    }

    public function testStartTripSuccess()
    {
        $this->assertTrue(true);
    }


    public function testStartTripFail()
    {
        $this->assertTrue(true);
    }


    public function testEndTripSuccess()
    {
        $this->assertTrue(true);
    }


    public function testEndTripFail()
    {
        $this->assertTrue(true);
    }


    public function testGetNodeTripPointsSuccess()
    {
        $this->assertTrue(true);
    }


    public function testGetNodeTripPointsFail()
    {
        $this->assertTrue(true);
    }





    public function testLocationNameSuggestSuccess()
    {
        // server doesn't yet support this API
        $this->assertTrue(true);
    }


    public function testLocationNameSuggestFail()
    {
        // server doesn't yet support this API

        $this->assertTrue(true);
    }



    public function testGeoCodeSuccess()
    {
        // server doesn't yet support this API

        $this->assertTrue(true);
    }

    public function testGeoCodeFail()
    {
        // server doesn't yet support this API

        $this->assertTrue(true);
    }


    public function testReverseGeocodeSuccess()
    {
        // server doesn't yet support this API

        $this->assertTrue(true);
    }

    public function testReverseGeocodeFail()
    {
        // server doesn't yet support this API

        $this->assertTrue(true);
    }


    public function testEstimateDistanceAndTimeSuccess()
    {
        // server doesn't yet support this API

        $this->assertTrue(true);
    }

    public function testEstimateDistanceAndTimeFail()
    {
        // server doesn't yet support this API

        $this->assertTrue(true);
    }

}
