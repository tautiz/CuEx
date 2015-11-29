<?php

/*
 * This file is part of CuEx.
 *
 * (c) Tautvydas Dulskis <tautvydas@dulskis.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CuEx\Provider;

use Ivory\HttpAdapter\HttpAdapterInterface;
use CuEx\ProviderInterface;

/**
 * Base class for providers.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
abstract class AbstractProvider implements ProviderInterface
{
    protected $httpAdapter;

    public function __construct(HttpAdapterInterface $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;
    }

    /**
     * Fetches the content of the given url.
     *
     * @param string $url
     *
     * @return string
     */
    protected function fetchContent($url)
    {
        return (string) $this->httpAdapter->get($url)->getBody();
    }
}
