<?php
namespace mhndev\locationClient\objects;

/**
 * Class NeighbourNode
 * @package mhndev\locationClient
 */
class NeighbourNode
{

    /**
     * @var integer
     */
    protected $identifier;

    /**
     * @var float
     */
    protected $distance;

    /**
     * @var Point
     */
    protected $lastLocation;

    /**
     * NeighbourNode constructor.
     *
     * @param int $identifier
     * @param float $distance
     * @param Point $lastLocation
     */
    public function __construct($identifier, $distance, Point $lastLocation)
    {
        $this->identifier = $identifier;
        $this->distance = $distance;
        $this->lastLocation = $lastLocation;
    }



    /**
     * @return int
     */
    public function getIdentifier(): int
    {
        return $this->identifier;
    }

    /**
     * @param int $identifier
     * @return $this
     */
    public function setIdentifier(int $identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * @param float $distance
     * @return $this
     */
    public function setDistance(float $distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return Point
     */
    public function getLastLocation(): Point
    {
        return $this->lastLocation;
    }

    /**
     * @param Point $lastLocation
     * @return $this
     */
    public function setLastLocation(Point $lastLocation)
    {
        $this->lastLocation = $lastLocation;

        return $this;
    }


}
