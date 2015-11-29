<?php

/*
 * This file is part of CuEx.
 *
 * (c) Tautvydas Dulskis <tautvydas@dulskis.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CuEx\Model;

/**
 * Represents a rate.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
final class Rate
{
    private $value;
    private $date;
    private $providerName;

    /**
     * Creates a new rate.
     *
     * @param string         $value The rate value
     * @param \DateTime|null $date  The date at which this rate was calculated
     */
    public function __construct($value, \DateTime $date = null, $providerName = null)
    {
        $this->value = (string) $value;
        $this->providerName = (string) $providerName;
        $this->date = $date ?: new \DateTime();
    }

    /**
     * Returns Providers name
     *
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * Sets Providers name
     *
     * @param string $providerName
     */
    public function setProviderName($providerName)
    {
        $this->providerName = $providerName;
    }

    /**
     * Gets the rate value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Gets the date at which this rate was calculated.
     *
     * @return \Datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Returns the rate value.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
