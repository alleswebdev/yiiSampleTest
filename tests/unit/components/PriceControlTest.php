<?php

namespace tests\components;

use app\components\PriceControl;

class PriceControlTest extends \Codeception\Test\Unit
{
    /**
     * @expectedException \yii\base\InvalidArgumentException
     * @dataProvider initInvalidProvider
     */
    public function testOnExceptionInit($tolerance, $currentPrice, $previousPrice)
    {
        new PriceControl([
            'tolerance' => $tolerance,
            'currentPrice' => $currentPrice,
            'previousPrice' => $previousPrice,
        ]);
    }

    /**
     * @dataProvider diffValidProvider
     */
    public function testDiff($tolerance, $currentPrice, $previousPrice)
    {
        $obj = new PriceControl([
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
        $obj = new PriceControl([
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
        $obj = new PriceControl([
            'tolerance' => $tolerance,
            'currentPrice' => $currentPrice,
            'previousPrice' => $previousPrice,
        ]);

        $this->assertEquals($obj->amount, $amount);
    }

    public function testInvalideAmount()
    {
        $obj = new PriceControl([
            'tolerance' => 15,
            'currentPrice' => 1000,
            'previousPrice' => 1500,
        ]);

        //amout == 33
        $this->assertNotEquals($obj->amount, 35);
    }

    public function testSpecificAmount()
    {
        $obj = new PriceControl([
            'tolerance' => 20,
            'currentPrice' => 1000,
            'previousPrice' => 1200,
        ]);

        $this->assertTrue($obj->diff());
        $this->assertEquals($obj->amount, -16);
    }

    public function testSpecific2Amount()
    {
        $obj = new PriceControl([
            'tolerance' => 5,
            'currentPrice' => 1000,
        ]);

        $this->assertTrue($obj->diff());
        $this->assertEquals($obj->amount, 0);
    }

    public function testSpecific3Amount()
    {
        $obj = new PriceControl([
            'tolerance' => 20,
            'currentPrice' => 1200,
            'previousPrice' => 1000,
        ]);

        $this->assertTrue($obj->diff());
        $this->assertEquals($obj->amount, 20);
    }

    public function testSpecific4Amount()
    {
        $obj = new PriceControl([
            'tolerance' => 35,
            'currentPrice' => 130,
            'previousPrice' => 100,
        ]);

        $this->assertTrue($obj->diff());
        $this->assertEquals($obj->amount, 30);
    }

    public function testDefaultTolerance()
    {
        $obj = new PriceControl([
            'currentPrice' => 130,
            'previousPrice' => 100,
        ]);

        $this->assertFalse($obj->diff());
        $this->assertEquals($obj->amount, 30);
        $this->assertEquals($obj->tolerance, 10);
    }

    public function testDefaultTolerance2()
    {
        $obj = new PriceControl([
            'currentPrice' => 110,
            'previousPrice' => 100,
        ]);

        $this->assertTrue($obj->diff());
        $this->assertEquals($obj->amount, 10);
        $this->assertEquals($obj->tolerance, 10);
    }

    public function initInvalidProvider()
    {
        return [
            [
                'tolerance' => 5,
                'currentPrice' => 0,
                'previousPrice' => 1,
            ],
            [
                'tolerance' => 0,
                'currentPrice' => 0,
                'previousPrice' => 1,
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
                'amount' => -20,
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
                'amount' => -5,
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

