<?php
/**
 * Factory
 *
 * @package   PickBean
 * @author    Monkey  <Monkey@dm-miniprogram.com>
 * @copyright Copyright (C) 2019 Monkey
 */
namespace China\Math\Expression;


use China\Math\Calculation\Adapter\AddOperation;
use China\Math\Calculation\Adapter\DivOperation;
use China\Math\Calculation\Adapter\ModOperation;
use China\Math\Calculation\Adapter\MulOperation;
use China\Math\Calculation\Adapter\SquareOperation;
use China\Math\Calculation\Adapter\SubOperation;
use China\Math\Calculation\OperationException;
use China\Math\Expression\Calculator\Pattern;
use China\Math\Expression\Calculator\Symbol;
use RuntimeException;
use SplStack;


/**
 * Class Calculator
 * @package China\Math\Expression
 */
class Calculator
{

    /**
     * @var SplStack
     */
    private $result_stack;

    /**
     * @var Symbol
     */
    private $symbol;

    /**
     * Calculator constructor.
     * @param Symbol|null $symbol
     */
    public function __construct(?Symbol $symbol = null)
    {
        if (!$symbol) {
            $symbol = new Symbol();
        }
        $this->symbol = self::addSymbol($symbol);
    }

    /**
     * @param string $expression
     * @return Calculator
     * @throws OperationException
     */
    public function pattern(string $expression): self
    {
        $this->result_stack = self::change($expression, new SplStack(), new SplStack());
        if (!$this->result_stack) {
            throw new OperationException("未解析参数");
        }
        return $this;
    }

    /**
     * @param array $data
     * @param int $scale
     * @return string
     */
    public function calc(array $data, int $scale = 2): string
    {
        return (new Pattern($this->result_stack))->calc($data, $scale, $this->symbol);
    }

    /**
     * @param string $expression
     * @param SplStack $symbol_stack
     * @param SplStack $result_stack
     * @return SplStack
     * @throws OperationException
     */
    private function change(string $expression, SplStack $symbol_stack,
                            SplStack $result_stack): SplStack
    {
        if (strlen($expression) === 0) {
            $length = $symbol_stack->count();
            for ($i = 0; $i < $length; $i++) {
                $result_stack->push($symbol_stack->pop());
            }
            return $result_stack;
        }
        $param = substr($expression, 0, 1);
        if ($param !== ' ') {
            if (in_array($param, $this->symbol->getSymbol())) {
                //如果S1为空，或栈顶运算符为左括号“(”，则直接将此运算符入栈；
                if ($symbol_stack->count() === 0 || $param === '(') {
                    $symbol_stack->push($param);
                } else if ($param === ')') {
                    list($symbol_stack, $result_stack) = self::next($symbol_stack, $result_stack);
                } else {
                    if ($this->symbol->getWeight()[$param] < $this->symbol->getWeight()[$symbol_stack->top()]) {
                        // 若优先级比栈顶运算符的高，也将运算符压入S1（注意转换为前缀表达式时是优先级较高或相同，而这里则不包括相同的情况）；
                        list($symbol_stack, $result_stack) = self::compare($param, $symbol_stack, $result_stack);
                    } else {
                        $symbol_stack->push($param);
                    }
                }
            } else {
                $result_stack->push($param);
            }
        }
        return self::change(substr($expression, 1, strlen($expression) - 1),
            $symbol_stack, $result_stack);
    }

    /**
     * @param SplStack $symbol_stack
     * @param SplStack $result_stack
     * @return array
     */
    private static function next(SplStack $symbol_stack, SplStack $result_stack): array
    {
        //如果是右括号“)”，则依次弹出S1栈顶的运算符，并压入S2，直到遇到左括号为止，此时将这一对括号丢弃；
        if ($symbol_stack->top() === '(') {
            $symbol_stack->pop();
            return array($symbol_stack, $result_stack);
        } else {
            $result_stack->push($symbol_stack->top());
            $symbol_stack->pop();
            return self::next($symbol_stack, $result_stack);
        }
    }

    /**
     * @param string $param
     * @param SplStack $symbol_stack
     * @param SplStack $result_stack
     * @return array
     * @throws OperationException
     */
    private function compare(string $param, SplStack $symbol_stack, SplStack $result_stack): array
    {
        if ($this->symbol->getWeight()[$param] < $this->symbol->getWeight()[$symbol_stack->top()] &&
            $symbol_stack->top() !== '(') {
            try {

                $result_stack->push($symbol_stack->pop());
            } catch (RuntimeException $e) {
                throw new OperationException("未知错误: {$e->getMessage()}");
            }
            if ($symbol_stack->count() > 0) {
                return self::compare($param, $symbol_stack, $result_stack);
            }
        }
        $symbol_stack->push($param);
        return array($symbol_stack, $result_stack);
    }

    /**
     * @param Symbol $symbol
     * @return Symbol
     */
    private static function addSymbol(Symbol $symbol): Symbol {
        $symbol->addSymbol((new Injection('+'))->bindOperation(Symbol::MATH_SYMBOL_WEIGHT_10, AddOperation::class));
        $symbol->addSymbol((new Injection('-'))->bindOperation(Symbol::MATH_SYMBOL_WEIGHT_10, SubOperation::class));
        $symbol->addSymbol((new Injection('*'))->bindOperation(Symbol::MATH_SYMBOL_WEIGHT_20, MulOperation::class));
        $symbol->addSymbol((new Injection('/'))->bindOperation(Symbol::MATH_SYMBOL_WEIGHT_20, DivOperation::class));
        $symbol->addSymbol((new Injection('('))->bindOperation(Symbol::MATH_SYMBOL_WEIGHT_100));
        $symbol->addSymbol((new Injection(')'))->bindOperation(Symbol::MATH_SYMBOL_WEIGHT_100));
        $symbol->addSymbol((new Injection('%'))->bindOperation(Symbol::MATH_SYMBOL_WEIGHT_20, ModOperation::class));
        $symbol->addSymbol((new Injection('^'))->bindOperation(Symbol::MATH_SYMBOL_WEIGHT_500, SquareOperation::class));
        return $symbol;
    }

}