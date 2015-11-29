<?php
    namespace CuEx\Console;

    use CuEx\CuEx;
    use Illuminate\Console\Command;

    class BestRateCommand
        extends Command
    {
        protected $name = 'rate:best';
        protected $description = 'Gives the best exchange rate for a given currency pair. (ex. EUR/LTL)';
        protected $cuex;

        public function __construct(Cuex $cuex)
        {
            $this->cuex = $cuex;

            parent::__construct();
        }

        public function fire()
        {
            $currencyPair = $this->ask('What currency, exchange rate you wish to see (ex. EUR/LTL) ?');
            $rate = $this->cuex->getRate($currencyPair)->getValue();
            $this->info('There is you best exchange rate: '.$rate);

        }
    }
