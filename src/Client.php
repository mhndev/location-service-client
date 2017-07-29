<?php
namespace mhndev\locationClient;

use GuzzleHttp\Client as httpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use mhndev\locationClient\exceptions\ConnectException as LocationConnectException;
use mhndev\locationClient\exceptions\EmptyResultSetException;
use mhndev\locationClient\exceptions\LocationServerErrorException;
use mhndev\locationClient\exceptions\UnAuthorizedException;
use mhndev\locationClient\objects\Location;
use mhndev\locationClient\objects\NeighbourNode;
use mhndev\locationClient\objects\Node;
use mhndev\locationClient\objects\Point;
use Psr\Http\Message\ResponseInterface;

/**
 * Class LocationClient
 * @package mhndev\digipeyk\services
 */
class Client
{


    /**
     * @var string
     */
    protected $host;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $token;


    /**
     * LocationClient constructor
     * @param string $host
     * @param int $port
     * @param string $token
     */
    public function __construct(string $host, int $port, string $token)
    {
        $this->host = $host;
        $this->port = $port;
        $this->token = $token;

        $this->httpClient = new httpClient([
            'base_uri' => $host.':'.$port,
        ]);
    }


    /**
     * @param float $latitude
     * @param float $longitude
     * @param int $n number of nodes
     * @param int $r radius around given point
     * @param bool $throwExceptionOnEmptyResultSet
     * @return array of mhndev\locationClient\NeighbourNode
     */
    public function nearestNeighbours(
        float $latitude,
        float $longitude,
        int $n = 10,
        int $r = 1000,
        bool $throwExceptionOnEmptyResultSet = false
    )
    {
        $uri = $this->getAddresses(__FUNCTION__);

        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token
            ],
            'query' => [
                'lat' => $latitude,
                'lon' => $longitude,
                'radius' => $r,
                'k' => $n
            ]
        ];


        $response = $this->request($uri, $options);

        $nodes = $this->getResult($response)['result'];


        $result = [];

        if(empty($nodes)){
            if($throwExceptionOnEmptyResultSet){
                throw new EmptyResultSetException();
            }
        }
        else{

            foreach ($nodes as $node){
                $result[] = new NeighbourNode(
                    $node['id'],
                    $node['distance'],
                    new Point($node['location']['lat'], $node['location']['lon'])
                );
            }
        }


        return $result;
    }


    /**
     * @param string $query
     * @param int $page
     * @param int $perPage
     */
    public function locationNameSuggest(
        string $query,
        int $page = 1,
        int $perPage = 10
    )
    {
        // todo

    }


    /**
     * @param string $location_name
     * @return Location
     */
    public function geoCode(string $location_name)
    {
        // todo

    }


    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return Location
     */
    public function reverseGeocode(float $latitude, float $longitude)
    {
        // todo

    }


    /**
     * @param Location $A
     * @param Location $B
     * @param \DateTime|null $time
     */
    public function EstimateDistanceAndTime(
        Location $A,
        Location $B,
        \DateTime $time = null
    )
    {
        if(empty($time)){
            $time = new \DateTime();
        }

        // todo
    }


    /**
     * @param Node $node
     */
    public function saveLastLocation(Node $node)
    {

    }


    /**
     * @param Node $node
     */
    public function changeNodeState(Node $node)
    {

    }


    /**
     * @param Node $node
     * @param $trip_id
     */
    public function startTrip(Node $node, $trip_id)
    {

    }


    /**
     * @param Node $node
     * @param $trip_id
     */
    public function endTrip(Node $node, $trip_id)
    {

    }


    /**
     * @param Node $node
     * @param $trip_id
     *
     * @return array return array of points
     */
    public function getNodeTripPoints(Node $node, $trip_id)
    {

        // todo
        return [];
    }


    /**
     * @param string $action
     * @return string
     */
    private function getAddresses(string $action) :string
    {
        $addresses = [
            'getNodeTripPoints' => '',
            'startTrip' => '/trip',
            'endTrip' => '/trip/end',
            'changeNodeState' => '/location/state',
            'saveLastLocation' => '/location',
            'EstimateDistanceAndTime' => '',
            'reverseGeocode' => '',
            'geoCode' => '',
            'locationNameSuggest' => '',
            'nearestNeighbours' => '/location/knn'
        ];

        return $addresses[$action];
    }


    /**
     * @param ResponseInterface $response
     * @return array
     * @throws UnAuthorizedException
     */
    private function getResult(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }


    /**
     * @param $uri
     * @param array $options
     * @return ResponseInterface
     * @throws UnAuthorizedException
     * @throws \Exception
     */
    private function request($uri, array $options)
    {
        try{
            $response = $this->httpClient->get($uri, $options);
        }catch (ConnectException $e){
            throw new LocationConnectException(
                'Cannot Establish connection to Location Service'.$e->getMessage()
            );
        }
        catch (ClientException $e){
            if($e->getResponse()->getStatusCode() == 401){
                throw new UnAuthorizedException();
            }elseif ($e->getResponse()->getStatusCode() >= 500){
                throw new LocationServerErrorException($e->getResponse()->getBody()->getContents());
            }

            else{
                throw new \Exception('Unhandled Exception');
            }

        }catch (\Exception $e){
            throw new \Exception('Unhandled Exception');
        }

        return $response;
    }

}
