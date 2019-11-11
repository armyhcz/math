<?php

require_once __DIR__ . '/../vendor/autoload.php';


class AndOperation extends \Math\Calculation\AbstractOperation {

    /**
     * @param string $left
     * @param string $right
     * @return string
     */
    public function __invoke(string $left, string $right): string {
        return \Math\Number\Formatter::format($left === $right ? 1 : 2, $this->scale);
    }

}


//(a+b+c)*d-f*m
$symbol = (new \Math\Expression\Calculator\Symbol())->setSymbol('&')
    ->setWeight('&', 2)->setOperation('&', AndOperation::class);
$a = (new \Math\Expression\Calculator($symbol))->pattern('(a+b+c)*d-f*m&o');
var_dump($a->calc(array(
    'a' => 3,
    'b' => 4,
    'c' => 5,
    'd' => 6,
    'f' => 4,
    'm' => 5,
    'o' => 0,
), 5));
