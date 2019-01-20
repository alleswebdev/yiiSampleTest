<?php

namespace app\components;

use yii\base\BaseObject;
use yii\base\InvalidArgumentException;

/**
 * Class PriceControl
 *
 *     $obj = new PriceControl([
 *       'tolerance' => 5,
 *       'currentPrice' => 1000,
 *       'previousPrice' => 1200,
 *     ]);
 *
 *     определит допустимо ли отклонение
 *     $obj->diff();
 *     текущее отклонение
 *     $obj->amount;
 *
 * @package app\components
 */
class PriceControl extends BaseObject
{
    /**
     * @var int
     */
    public $tolerance;
    /**
     * @var int
     */
    public $currentPrice;
    /**
     * @var int
     */
    public $previousPrice;
    /**
     * @var int
     */
    private $_amount = 0;

    /**
     * @return int
     */
    public function getAmount() : int
    {
        return $this->_amount;
    }

    public function setAmount(int $value)
    {
        $this->_amount = $value;
    }

    public function init()
    {
        parent::init();

        if ($this->tolerance <= 0 || $this->currentPrice <= 0) {
           throw  new InvalidArgumentException("Не заданы обязательные параметры");
        }

        if (isset($this->previousPrice) && $this->previousPrice <= 0) {
            throw  new InvalidArgumentException("Прошлая цена должна быть больше 0");
        }

        if ($this->previousPrice) {
            //процент отклонения текущей цены от предыдущей
            $this->amount = abs(100 - $this->currentPrice * 100 / $this->previousPrice);
        }
    }

    /**
     * @return bool
     */
    public function diff() : bool
    {
        if ($this->amount > $this->tolerance) {
            return false;
        }

        return true;
    }
}
