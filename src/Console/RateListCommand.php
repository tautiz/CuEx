<?php
    namespace CuEx\Console;

    use CuEx\CuEx;
    use Illuminate\Console\Command;

    class RateListCommand
        extends Command
    {
        protected $name = 'rate:list';
        protected $description = 'Gives the exchange rate list from providers for a given currency pair. (ex. EUR/LTL)';
        protected $cuex;

        public function __construct(Cuex $cuex)
        {
            $this->cuex = $cuex;

            parent::__construct();
        }

        public function fire()
        {
            $currencyPair = $this->ask('What currency, exchange rate you wish to see (ex. EUR/LTL) ?');
            $rates = $this->cuex->getRates($currencyPair);
            $this->info("There is you rate list:");
            $this->info('<Provider> : <Rate>');

            /** @var \CuEx\Model\Rate $rate */
            foreach($rates as $rate){
                $this->info($rate->getProviderName() ." : ". $rate->getValue());
            }
        }
    }
