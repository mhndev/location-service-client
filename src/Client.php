<?php
namespace mhndev\locationClient;

use GuzzleHttp\Client as httpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use mhndev\locationClient\exceptions\ConnectException as LocationConnectException;
use mhndev\locationClient\exceptions\EmptyResultSetException;
use mhndev\locationClient\exceptions\LocationServerErrorException;
use mhndev\locationClient\exceptions\UnAuthorizedException;
use mhndev\locationClient\interfaces\iClient;
use mhndev\locationClient\objects\Location;
use mhndev\locationClient\objects\NeighbourNode;
use mhndev\locationClient\objects\Node;
use Psr\Http\Message\ResponseInterface;

/**
 * Class LocationClient
 * @package mhndev\digipeyk\services
 */
class Client implements iClient
{
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
     *
     * @param string $token
     * @param httpClient $client
     */
    public function __construct(httpClient $client, string $token)
    {
        $this->httpClient = $client;
        $this->token = $token;
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
            'headers' => [ 'Authorization' => 'Bearer '.$this->token ],
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
                $result[] = NeighbourNode::fromServerArray($node);
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
     * @return Node
     */
    public function saveLastLocation(Node $node)
    {
        $uri = $this->getAddresses(__FUNCTION__);

        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token,
                'Content-Type'  => 'application/json'
            ],
            'json' => [
                'id' => $node->getIdentifier(),
                'location' => [
                    'lat' => $node->getLatitude(),
                    'lon' => $node->getLongitude()
                ]
            ]
        ];

        $response = $this->request($uri, $options, 'post');
        $nodeArray = $this->getResult($response);

        return Node::fromServerArray($nodeArray['result']);
    }


    /**
     * @param Node $node
     * @return Node
     */
    public function changeNodeState(Node $node)
    {
        $uri = $this->getAddresses(__FUNCTION__);

        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token,
                'Content-Type'  => 'application/json'
            ],
            'json' => [
                'id' => $node->getIdentifier(),
                'state' => $node->getState()
            ]
        ];

        $response = $this->request($uri, $options, 'post');
        $nodeArray = $this->getResult($response);

        return Node::fromArray($nodeArray['result']);
    }


    /**
     * @param Node $node
     * @param string $trip_id
     *
     * @return boolean
     */
    public function startTrip(Node $node, string $trip_id)
    {
        $uri = $this->getAddresses(__FUNCTION__);

        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token,
                'Content-Type'  => 'application/json'
            ],
            'json' => [
                'node_id' => $node->getIdentifier(),
                'trip_id' => $trip_id
            ]
        ];

        $response = $this->request($uri, $options, 'post');

        if($this->getResult($response)['result'] == true){
            return true;
        }
        else{
            return false;
        }
    }


    /**
     * @param Node $node
     * @param string $trip_id
     * @return bool
     */
    public function endTrip(Node $node, string $trip_id)
    {
        $uri = $this->getAddresses(__FUNCTION__);

        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token,
                'Content-Type'  => 'application/json'
            ],
            'json' => [
                'node_id' => $node->getIdentifier(),
                'trip_id' => $trip_id
            ]
        ];

        $response = $this->request($uri, $options, 'post');

        if($this->getResult($response)['result'] == true){
            return true;
        }
        else{
            return false;
        }
    }


    /**
     * @param Node $node
     * @param $trip_id
     *
     * @return array
     */
    public function getNodeTripPoints(Node $node, $trip_id)
    {
        $uri = $this->getAddresses(__FUNCTION__);

        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token,
                'Content-Type'  => 'application/json'
            ],
            'query' => [
                'node_id' => $node->getIdentifier(),
                'trip_id' => $trip_id
            ]
        ];

        $response = $this->request($uri, $options);

        return $this->getResult($response);
    }


    /**
     * @param string $action
     * @return string
     */
    private function getAddresses(string $action) :string
    {
        $addresses = [
            'getNodeTripPoints'       => '/trip',
            'startTrip'               => '/trip',
            'endTrip'                 => '/trip/end',
            'changeNodeState'         => '/location/state',
            'saveLastLocation'        => '/location',
            'nearestNeighbours'       => '/location/knn',
            'EstimateDistanceAndTime' => '',
            'reverseGeocode'          => '',
            'geoCode'                 => '',
            'locationNameSuggest'     => ''
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
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws UnAuthorizedException
     * @throws \Exception
     */
    private function request(string $uri, array $options = [], $method = 'get')
    {
        try{
            $response = $this->httpClient->$method($uri, $options);
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
