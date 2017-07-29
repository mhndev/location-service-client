<?php
namespace mhndev\locationClient\objects;

/**
 * Class Location
 * @package mhndev\digipeyk\services
 */
class Location
{

    /**
     * @var
     */
    protected $location_id;

    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;

    /**
     * @var string
     */
    protected $string;

    /**
     * @var string
     */
    protected $preview;

    /**
     * @var string
     */
    protected $area;



    /**
     * Location constructor.
     *
     * @param integer $location_id
     * @param float $latitude
     * @param float $longitude
     * @param string $string
     * @param string $preview
     * @param string $area
     */
    public function __construct(
        $location_id,
        $latitude,
        $longitude,
        $string,
        $preview,
        $area
    )
    {
        $this->location_id = $location_id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->string = $string;
        $this->preview = $preview;
        $this->area = $area;
    }


    /**
     * @return integer
     */
    public function getLocationId(): int
    {
        return $this->location_id;
    }

    /**
     * @param int $location_id
     * @return $this
     */
    public function setLocationId(int $location_id)
    {
        $this->location_id = $location_id;

        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return $this
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return $this
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->string;
    }

    /**
     * @param string $string
     * @return $this
     */
    public function setString(string $string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * @return string
     */
    public function getPreview(): string
    {
        return $this->preview;
    }

    /**
     * @param string $preview
     * @return $this
     */
    public function setPreview(string $preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * @return string
     */
    public function getArea(): string
    {
        return $this->area;
    }

    /**
     * @param string $area
     * @return $this
     */
    public function setArea(string $area)
    {
        $this->area = $area;

        return $this;
    }



}
