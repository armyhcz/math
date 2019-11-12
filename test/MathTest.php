<?php
/**
 * MathTest
 *
 * @package   PickBean
 * @author    Monkey  <Monkey@dm-miniprogram.com>
 * @copyright Copyright (C) 2019 Monkey
 */
namespace China\Test;


use China\Math\Calculation\AbstractOperation;
use China\Math\Calculation\OperationException;
use China\Math\Expression\Calculator;
use China\Math\Number\Formatter;
use PHPUnit\Framework\TestCase;


/**
 * Class MathTest
 * @package China\Test
 */
final class MathTest extends TestCase
{

    /**
     * 自己添加方法
     */
    final public function testAdd()
    {
        $symbol = (new Calculator\Symbol())->setSymbol('&')
            ->setWeight('&', 2)->setOperation('&', AndOperation::class);
        try {
            $stack = (new Calculator($symbol))->pattern('(a+b+c)*d-f*m&o');
            $result = $stack->calc(array(
                'a' => 3,
                'b' => 4,
                'c' => 5,
                'd' => 6,
                'f' => 4,
                'm' => 5,
                'o' => 0,
            ), 1);
            $this->assertEquals($result, '2.0');
        } catch (OperationException $e) {
            var_dump(123);die();
        }

    }

    /**
     * 测试多个括号
     * @throws OperationException
     */
    final public function testBracket()
    {
        $stack = (new Calculator())->pattern('a+((b+c)*d)-f');
        $result = $stack->calc(array(
            'a' => 3,
            'b' => 4,
            'c' => 5,
            'd' => 6,
            'f' => 4,
            'm' => 5,
            'o' => 0,
        ), 3);
        $this->assertEquals($result, '53.000');
    }

    /**
     * 测试全部方法
     * @throws OperationException
     */
    final public function testAll()
    {
        $stack = (new Calculator())->pattern('(a+(b-c*d)/e+f^(g+h)-i/j)%a');
        $result = $stack->calc(array(
            'a' => 2,
            'b' => 4,
            'c' => 5,
            'd' => 6,
            'e' => 2,
            'f' => 4,
            'g' => 2,
            'h' => 1,
            'i' => 6,
            'j' => 3,
        ), 4);
        $this->assertEquals($result, '1.0000');
    }

}


class AndOperation extends AbstractOperation
{

    /**
     * @param string $left
     * @param string $right
     * @return string
     */
    public function __invoke(string $left, string $right): string
    {
        return Formatter::format($left === $right ? 1 : 2, $this->scale);
    }

}