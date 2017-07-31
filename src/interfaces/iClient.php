<?php
namespace mhndev\locationClient\interfaces;

use mhndev\locationClient\objects\Location;
use mhndev\locationClient\objects\Node;

/**
 * Client Object which talks to Location Server
 * and implement Location server functions
 *
 * Interface iClient
 * @package mhndev\locationClient\interfaces
 */
interface iClient
{


    /**
     * Find Nearest nodes (any entity which has location(lat, lon) and maybe has state (status) )
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $n number of nodes
     * @param int $r radius around given point
     * @param bool $returnArrayOfObjects
     * @return array of mhndev\locationClient\NeighbourNode
     */
    public function nearestNeighbours(
        float $latitude,
        float $longitude,
        int $n = 10,
        int $r = 1000,
        $returnArrayOfObjects = false
    );


    /**
     * Search Location based on location name
     * for example when you type "Mird" you should get every location which contains "Mird" string
     * based on your pagination
     *
     * @param string $query
     * @param int $page
     * @param int $perPage
     */
    public function locationNameSuggest(string $query, int $page = 1, int $perPage = 10);


    /**
     * Convert location name which is a string to geographical coordinate (lat, lon)
     *
     * @param string $location_name
     * @return Location
     */
    public function geoCode(string $location_name);


    /**
     * Converts geographical coordinate to location name which is a string
     *
     * @param float $latitude
     * @param float $longitude
     *
     * @return Location
     */
    public function reverseGeocode(float $latitude, float $longitude);


    /**
     * Estimate distance between two point going through roads available
     * and also time takes to reach from point A to point B
     * consider time given could be different based on given dateTime object (traffic aware)
     *
     * @param Location $A
     * @param Location $B
     * @param \DateTime|null $time
     */
    public function EstimateDistanceAndTime(Location $A, Location $B, \DateTime $time = null);


    /**
     * Save Location of your Agent (coordinate aware object)
     *
     * @param Node $node
     * @return Node
     */
    public function saveLastLocation(Node $node);


    /**
     * Change State (status) of your Agent'
     *
     * @param Node $node
     * @return Node
     */
    public function changeNodeState(Node $node);


    /**
     * You can Have your trips saved in location server
     * by calling startTrip function and giving this function the Agent object and trip_id
     * this way location server automatically starts to save locations given by Agent from now on as
     * a trip by ID which you specified
     * and when trip is finished you should call endTrip function
     *
     *
     * @param Node $node
     * @param string $trip_id
     *
     * @return boolean
     */
    public function startTrip(Node $node, string $trip_id);


    /**
     * Ends started trip by an Agent
     *
     * @param Node $node
     * @param string $trip_id
     * @return bool
     */
    public function endTrip(Node $node, string $trip_id);


    /**
     * Shows a Trip points by its trip_id
     *
     * @param Node $node
     * @param $trip_id
     *
     * @return array
     */
    public function getNodeTripPoints(Node $node, $trip_id);

}
