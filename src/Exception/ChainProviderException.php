<?php

/*
 * This file is part of CuEx.
 *
 * (c) Tautvydas Dulskis <tautvydas@dulskis.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CuEx\Exception;

/**
 * Exception thrown by a ChainProvider allowing to retrieve exceptions that occured in the chain.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
class ChainProviderException extends Exception
{
    private $exceptions;

    /**
     * Creates a new chain exception.
     *
     * @param Exception[] $exceptions
     */
    public function __construct(array $exceptions)
    {
        $this->exceptions = $exceptions;
    }

    /**
     * Gets the exceptions indexed by provider class name.
     *
     * @return Exception[]
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }
}
