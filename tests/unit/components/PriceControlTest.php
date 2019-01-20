<?php

namespace tests\components;

use app\components\PriseControl;

class EchoTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testEcho()
    {
        $obj = new PriseControl([
            'tolerance' => 3,
            'currentPrice' => 4,
            'previousPrice' => 4,
            'result' => 4,
        ]);

        expect_that($obj->testEcho());
    }
}
