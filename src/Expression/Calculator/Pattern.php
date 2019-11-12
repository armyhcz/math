<?php
/**
 * Pattern
 *
 * @package   PickBean
 * @author    Monkey  <Monkey@dm-miniprogram.com>
 * @copyright Copyright (C) 2019 Monkey
 */
namespace China\Math\Expression\Calculator;


use SplStack;


/**
 * Class Pattern
 * @package China\Math\Expression\Calculator
 */
class Pattern
{

    /**
     * @var SplStack
     */
    protected $stack;

    /**
     * Pattern constructor.
     * @param SplStack $stack
     */
    public function __construct(SplStack $stack)
    {
        $this->stack = $stack;
    }

    /**
     * @param array $data
     * @param int $scale
     * @param Symbol|null $symbol
     * @return string
     */
    public function calc(array $data, int $scale, ?Symbol $symbol = null): string
    {
        $value_stack = new SplStack();
        if (!$symbol) {
            $symbol = new Symbol();
        }
        $math_symbol = $symbol->getSymbol();
        $length = $this->stack->count();
        for ($i = 0; $i < $length; $i++) {
            $value = $this->stack->shift();
            if (in_array($value, $math_symbol)) {
                $class = $symbol->getOperation($value, $scale);
                $right = $value_stack->pop();
                $left = $value_stack->pop();
                $value_stack->push($class(doubleval($data[$left] ?? $left),
                    doubleval($data[$right] ?? $right)));
            } else {
                $value_stack->push($value);
            }
        }
        return $value_stack->top();
    }

}