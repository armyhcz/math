<?php
/**
 * Symbol
 *
 * @package   PickBean
 * @author    Monkey  <Monkey@dm-miniprogram.com>
 * @copyright Copyright (C) 2019 Monkey
 */
namespace China\Math\Expression\Calculator;


use China\Math\Expression\Injection;


/**
 * Class Symbol
 * @package China\Math\Expression\Calculator
 */
class Symbol
{

    /**
     * @var array
     */
    private $operation = array();

    /**
     * @var array
     */
    private $weight = array();

    /**
     * @var array
     */
    private $symbol = array();

    /**
     * @return array
     */
    public function __invoke()
    {
        return $this->operation;
    }

    /**
     * @return array
     */
    public function getWeight(): array
    {
        return $this->weight;
    }

    /**
     * @return array
     */
    public function getSymbol(): array
    {
        return $this->symbol;
    }

    /**
     * @param string|null $symbol
     * @param int $scale
     * @return mixed
     */
    public function getOperation(string $symbol, int $scale = 2)
    {
        if (isset($this->operation[$symbol])) {
            return new $this->operation[$symbol]($scale);
        }
        return null;
    }

    /**
     * @param Injection $injection
     * @return Symbol
     */
    public function addSymbol(Injection $injection): self {
        list($weight, $operation) = $injection->getBindData();
        $this->symbol = array_merge($this->symbol, array($injection->getSymbol()));
        $this->operation = array_merge($this->operation, $operation);
        $this->weight = array_merge($this->weight, $weight);
        return $this;
    }

    /**
     * @var int
     */
    public const MATH_SYMBOL_WEIGHT_1 = 1;

    /**
     * @var int
     */
    public const MATH_SYMBOL_WEIGHT_10 = 10;

    /**
     * @var int
     */
    public const MATH_SYMBOL_WEIGHT_20 = 20;

    /**
     * @var int
     */
    public const MATH_SYMBOL_WEIGHT_50 = 50;

    /**
     * @var int
     */
    public const MATH_SYMBOL_WEIGHT_100 = 100;

    /**
     * @var int
     */
    public const MATH_SYMBOL_WEIGHT_500 = 500;

}