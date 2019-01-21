<?php

namespace app\components;

use yii\base\BaseObject;
use yii\base\InvalidArgumentException;

/**
 * Class PriceControl
 *     Класс позволяет контроллировать наценку/скидку между прошлой и текущей ценой
 *     пример использования:
 *     $obj = new PriceControl([
 *       'tolerance' => 5, // допустимое отклонение
 *       'currentPrice' => 100, // текущая цена
 *       'previousPrice' => 120, // предыдущая цена
 *     ]);
 *
 *     определит допустимо ли отклонение в 5% между 100 и 120
 *     $obj->diff(); // вернёт false, тк отклонение = 16%
 *     получить текущее отклонение
 *     $obj->amount; // == -16
 *
 * @property int $amount This property is read-only.
 *
 * @package app\components
 */
class PriceControl extends BaseObject
{
    /**
     * Допустимое отклонение текущей цены от предыдущей в %, по умолчанию = 10
     * @var int
     */
    public $tolerance;
    /**
     * Текущая цена
     * @var int
     */
    public $currentPrice;
    /**
     * Предыдущая цена
     * @var int
     */
    public $previousPrice;
    /**
     * Текущее отклонение(скидка/наценка)
     * @var int
     */
    private $_amount = 0;

    /**
     * Геттер текущего отклонения
     * @return int
     */
    public function getAmount() : int
    {
        return $this->_amount;
    }

    /**
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
        if (!isset($config["tolerance"])) {
            $config["tolerance"] = 10;
        }

        parent::__construct($config);
    }

    /**
     * Выполняет инициализацию, рассчитывает текущее отклонение
     */
    public function init()
    {
        parent::init();

        if ($this->currentPrice <= 0) {
            throw  new InvalidArgumentException("Не задана текущая цена");
        }

        if ($this->previousPrice > 0) {
            //процент отклонения текущей цены от предыдущей
            $this->_amount = ($this->currentPrice * 100 / $this->previousPrice) - 100;
        }
    }

    /**
     * Вычисляет допустимо ли текущее отклонения от заданного
     * @return bool
     */
    public function diff() : bool
    {
        if (abs($this->amount) > $this->tolerance) {
            return false;
        }

        return true;
    }
}
