<?php
/**
 * Symbol
 *
 * @package   PickBean
 * @author    Monkey  <Monkey@dm-miniprogram.com>
 * @copyright Copyright (C) 2019 Monkey
 */
namespace Math\Expression\Calculator;


use Math\Calculation\Adapter\AddOperation;
use Math\Calculation\Adapter\DivOperation;
use Math\Calculation\Adapter\MulOperation;
use Math\Calculation\Adapter\SubOperation;


/**
 * Class Symbol
 * @package Math\Expression\Calculator
 */
class Symbol {

    /**
     * @var array
     */
    private $add_operation = array();

    /**
     * @var array
     */
    private $weight = array();

    /**
     * @var array
     */
    private $symbol = array();

    /**
     * @param string $symbol
     * @param string $operation
     * @return Symbol
     */
    public function setOperation(string $symbol, string $operation): self {
        $this->add_operation = array(
            $symbol => $operation
        );
        return $this;
    }

    /**
     * @param string|null $symbol
     * @param int $scale
     * @return mixed
     */
    public function getOperation(?string $symbol = null, int $scale = 2) {
        $operation = array_merge(self::MATH_OPERATION, $this->add_operation);
        if ($symbol) {
            if (isset($operation[$symbol])) {
                return new $operation[$symbol]($scale);
            }
        }
        return $operation;
    }

    /**
     * @param string $symbol
     * @param int $weight
     * @return Symbol
     */
    public function setWeight(string $symbol, int $weight): self {
        $this->weight = array_merge($this->weight, array(
            $symbol => $weight
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function getWeight(): array {
        return array_merge(self::MATH_SYMBOL_WEIGHT, $this->weight);
    }

    /**
     * @param string $symbol
     * @return Symbol
     */
    public function setSymbol(string $symbol): self {
        $this->symbol = array_merge($this->symbol, array(
            $symbol
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function getSymbol(): array {
        return array_merge(self::MATH_SYMBOL, $this->symbol);
    }

    /**
     * @var array 运算符
     */
    private const MATH_SYMBOL = array(
        '+', '-', '*', '/', '(', ')',
    );

    /**
     * @var array 权重比较
     */
    private const MATH_SYMBOL_WEIGHT = array(
        '+' => 10,
        '-' => 10,
        '*' => 20,
        '/' => 20,
        '(' => 100,
        ')' => 100,
    );

    /**
     * @var array 对应操作
     */
    private const MATH_OPERATION = array(
        '+' => AddOperation::class,
        '-' => SubOperation::class,
        '*' => MulOperation::class,
        '/' => DivOperation::class,
    );

}