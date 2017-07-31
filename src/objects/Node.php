<?php
namespace mhndev\locationClient\objects;

/**
 * Class Node
 * @package mhndev\digipeyk\services
 */
class Node
{

    const STATE_READY = 'ready';
    const STATE_BUSY  = 'busy';
    const STATE_OUT   = 'out';

    const AVAILABLE_STATES = [
        self::STATE_BUSY,
        self::STATE_OUT,
        self::STATE_READY
    ];

    /**
     * @var string
     */
    protected $identifier;

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
    protected $state;

    /**
     * @var string
     */
    protected $trip_id;

    /**
     * Node constructor.
     *
     * @param string $identifier
     * @param float  $latitude
     * @param float  $longitude
     * @param string $state
     * @param string $trip_id
     */
    public function __construct(
        string $identifier,
        float $latitude,
        float $longitude,
        string $state = null,
        string $trip_id = null
    )
    {
        $this->identifier = $identifier;
        $this->latitude   = $latitude;
        $this->longitude  = $longitude;
        $this->state      = $state;
        $this->trip_id    = $trip_id;
    }


    /**
     * @param array $array
     * @return static
     */
    public static function fromArray(array $array)
    {
        $state = $array['state'] ?? '';
        $trip_id = $array['trip_id'] ?? '';

        return new static(
            $array['identifier'],
            $array['latitude'],
            $array['longitude'],
            $state,
            $trip_id
        );
    }

    /**
     * @param array $array
     * @return static
     */
    public static function fromServerArray(array $array)
    {
        $state = $array['state'] ?? '';
        $trip_id = $array['trip_id'] ?? '';

        return new static(
            $array['id'],
            $array['location']['lat'],
            $array['location']['lon'],
            $state,
            $trip_id
        );
    }


    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return $this
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;

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
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return $this
     */
    public function setState(string $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getTripId(): string
    {
        return $this->trip_id;
    }


    /**
     * @param string $trip_id
     * @return $this
     */
    public function setTripId(string $trip_id)
    {
        $this->trip_id = $trip_id;

        return $this;
    }



}
