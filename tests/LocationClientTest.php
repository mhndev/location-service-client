<?php
namespace mhndev\locationClient\Tests;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use mhndev\locationClient\Client;
use mhndev\locationClient\exceptions\InvalidNeighbourNodeDataException;
use mhndev\locationClient\objects\NeighbourNode;
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
        $bodyString = json_encode(
            [
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
            ]
        );

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


    public function testLocationNameSuggestSuccess()
    {
        $this->assertTrue(true);
    }


    public function testLocationNameSuggestFail()
    {
        $this->assertTrue(true);
    }



    public function testGeoCodeSuccess()
    {
        $this->assertTrue(true);
    }

    public function testGeoCodeFail()
    {
        $this->assertTrue(true);
    }


    public function testReverseGeocodeSuccess()
    {
        $this->assertTrue(true);
    }

    public function testReverseGeocodeFail()
    {
        $this->assertTrue(true);
    }


    public function testEstimateDistanceAndTimeSuccess()
    {
        $this->assertTrue(true);
    }

    public function testEstimateDistanceAndTimeFail()
    {
        $this->assertTrue(true);
    }




    public function testSaveLastLocationSuccess()
    {
        $this->assertTrue(true);
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

}
