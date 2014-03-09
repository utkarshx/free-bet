<?php

namespace BettingSas\Bundle\GambleBundle\Gamble;

use BettingSas\Bundle\GambleBundle\Exception\UnsupportedEventType;

class GambleChain
{
    /**
     * @var array
     */
    private $gambles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gambles = array();
    }

    /**
     * Get all gambles configured for a type
     *
     * @param string $type
     * @return array
     * @throws UnsupportedEventType
     */
    public function getGamblesByType($type)
    {
        if (!isset($this->gambles[$type])) {
            throw new UnsupportedEventType($type. ' not supported. Try '.implode(', ', array_keys($this->gambles)));
        }

        return $this->gambles[$type];
    }
    /**
     * Get gambles
     *
     * @return array
     */
    public function getGambles()
    {
        return $this->gambles;
    }

    /**
     * Register a new gamble type
     *
     * @param \BettingSas\Bundle\GambleBundle\Gamble\GambleInterface $gamble
     * @param string $type
     * @param int $order
     */
    public function addGamble(GambleInterface $gamble, $type, $order = null)
    {
        if (!isset($this->gambles[$type])) {
            $this->gambles[$type] = array();
        }

        if (is_int($order)) {
            $this->gambles[$type][] = $gamble;
        } else {
            array_push($this->gambles[$type], $gamble);
        }

        $this->sort();
    }

    /**
     * Sort the gambles array
     */
    public function sort()
    {
        foreach ($this->gambles as $type => $gamblesList) {
            ksort($this->gambles[$type]);
        }
    }
}