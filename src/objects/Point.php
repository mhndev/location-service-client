<?php
namespace mhndev\locationClient\objects;

/**
 * Class Point
 * @package mhndev\digipeyk\services
 */
class Point
{

    /**
     * @var float
     */
    protected $lat;

    /**
     * @var float
     */
    protected $lon;

    /**
     * Point constructor.
     * @param float $lat
     * @param float $lon
     */
    public function __construct(float $lat, float $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * @param Point $A
     * @return float
     */
    public function distanceFlat(Point $A)
    {
        return sqrt(
            ($this->lat - $A->getLat())^2 + ($this->lon - $A->getLon())^2
        );
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     * @return $this
     */
    public function setLat(float $lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return float
     */
    public function getLon(): float
    {
        return $this->lon;
    }

    /**
     * @param float $lon
     * @return $this
     */
    public function setLon(float $lon)
    {
        $this->lon = $lon;

        return $this;
    }


}
