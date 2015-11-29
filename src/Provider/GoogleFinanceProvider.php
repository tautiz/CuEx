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

use CuEx\Exception\Exception;
use CuEx\Model\CurrencyPair;
use CuEx\Model\Rate;

/**
 * Google Finance provider.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
class GoogleFinanceProvider extends AbstractProvider
{
    const URL = 'http://www.google.com/finance/converter?a=1&from=%s&to=%s';

    /**
     * {@inheritdoc}
     */
    public function fetchRate(CurrencyPair $currencyPair)
    {
        $url = sprintf(self::URL, $currencyPair->getBaseCurrency(), $currencyPair->getQuoteCurrency());
        $content = $this->fetchContent($url);

        $document = new \DOMDocument();
        @$document->loadHTML($content);

        $xpath = new \DOMXPath($document);
        $nodes = $xpath->query('//span[@class="bld"]');

        if (0 === $nodes->length) {
            throw new Exception('The currency is not supported or Google changed the response format');
        }

        $nodeContent = $nodes->item(0)->textContent;
        $bid = strstr($nodeContent, ' ', true);

        if (!is_numeric($bid)) {
            throw new Exception('The currency is not supported or Google changed the response format');
        }

        return new Rate($bid, new \DateTime(), "Google Finance");
    }
}
