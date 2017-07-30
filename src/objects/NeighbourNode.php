<?php
namespace mhndev\locationClient\objects;

use mhndev\locationClient\exceptions\InvalidNeighbourNodeDataException;

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
     * @param array $array
     * @return static
     */
    public static function fromArray(array $array)
    {
        if(empty($array['identifier']) || empty($array['distance']) || empty($array['location'])){
            throw new InvalidNeighbourNodeDataException();
        }

        return new static(
            $array['identifier'],
            $array['distance'],
            new Point($array['location']['lat'], $array['location']['lon'])
        );
    }


    public static function fromServerArray(array $array)
    {
        if(empty($array['id']) || empty($array['distance']) || empty($array['location'])){
            throw new InvalidNeighbourNodeDataException();
        }

        return new static(
            $array['id'],
            $array['distance'],
            new Point($array['location']['lat'], $array['location']['lon'])
        );
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
