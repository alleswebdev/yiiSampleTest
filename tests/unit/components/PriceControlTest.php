<?php

namespace tests\components;

use app\components\PriseControl;

class PriceControlTest extends \Codeception\Test\Unit
{
    /**
     * @expectedException \yii\base\InvalidArgumentException
     * @dataProvider initInvalidProvider
     */
    public function testOnExceptionInit($tolerance, $currentPrice, $previousPrice, $amount)
    {
        new PriseControl([
            'tolerance' => $tolerance,
            'currentPrice' => $currentPrice,
            'previousPrice' => $previousPrice,
            'amount' => $amount,
        ]);
    }

    /**
     * @dataProvider diffValidProvider
     */
    public function testDiff($tolerance, $currentPrice, $previousPrice)
    {
        $obj = new PriseControl([
            'tolerance' => $tolerance,
            'currentPrice' => $currentPrice,
            'previousPrice' => $previousPrice,
        ]);

        $this->assertTrue($obj->diff());
    }

    /**
     * @dataProvider diffInvalidProvider
     */
    public function testInvalidDiff($tolerance, $currentPrice, $previousPrice)
    {
        $obj = new PriseControl([
            'tolerance' => $tolerance,
            'currentPrice' => $currentPrice,
            'previousPrice' => $previousPrice,
        ]);

        $this->assertFalse($obj->diff());
    }

    /**
     * @dataProvider amountValidProvider
     */
    public function testAmount($tolerance, $currentPrice, $previousPrice, $amount)
    {
        $obj = new PriseControl([
            'tolerance' => $tolerance,
            'currentPrice' => $currentPrice,
            'previousPrice' => $previousPrice,
        ]);

        $this->assertEquals($obj->amount, $amount);
    }

    public function testInvalideAmount()
    {
        $obj = new PriseControl([
            'tolerance' => 15,
            'currentPrice' => 1000,
            'previousPrice' => 1500,
        ]);

        //amout == 33
        $this->assertNotEquals($obj->amount, 35);
    }

    public function initInvalidProvider()
    {
        return [
            [
                'tolerance' => 0,
                'currentPrice' => 4,
                'previousPrice' => 4,
                'amount' => 0
            ],
            [
                'tolerance' => 5,
                'currentPrice' => 0,
                'previousPrice' => 1,
                'amount' => 1
            ],
            [
                'tolerance' => 0,
                'currentPrice' => 0,
                'previousPrice' => 1,
                'amount' => 0
            ],
            [
                'tolerance' => 1,
                'currentPrice' => 1,
                'previousPrice' => 0,
                'amount' => 5,
            ],
        ];
    }

    public function amountValidProvider()
    {
        return [
            [
                'tolerance' => 25,
                'currentPrice' => 1000,
                'previousPrice' => 1250,
                'amount' => 20,
            ],
            [
                'tolerance' => 5,
                'currentPrice' => 3500,
                'previousPrice' => 3440,
                'amount' => 1,
            ],
            [
                'tolerance' => 10,
                'currentPrice' => 1140,
                'previousPrice' => 1200,
                'amount' => 5,
            ],
            [
                'tolerance' => 35,
                'currentPrice' => 1200,
                'previousPrice' => 900,
                'amount' => 33,
            ],
        ];
    }

    public function diffValidProvider()
    {
        return [
            [
                'tolerance' => 25,
                'currentPrice' => 1000,
                'previousPrice' => 1250,
            ],
            [
                'tolerance' => 15,
                'currentPrice' => 3500,
                'previousPrice' => 3441,
            ],
            [
                'tolerance' => 5,
                'currentPrice' => 1140,
                'previousPrice' => 1200,
            ],
            [
                'tolerance' => 33,
                'currentPrice' => 1200,
                'previousPrice' => 900,
            ],
        ];
    }

    public function diffInvalidProvider()
    {
        return [
            [
                'tolerance' => 1,
                'currentPrice' => 1000,
                'previousPrice' => 1250,
            ],
            [
                'tolerance' => 2,
                'currentPrice' => 1140,
                'previousPrice' => 1200,
            ],
            [
                'tolerance' => 25,
                'currentPrice' => 1200,
                'previousPrice' => 900,
            ],
        ];
    }
}

