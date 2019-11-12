<?php
/**
 * AddOperation
 *
 * @package   PickBean
 * @author    Monkey  <Monkey@dm-miniprogram.com>
 * @copyright Copyright (C) 2019 Monkey
 */
namespace China\Math\Calculation\Adapter;


use China\Math\Calculation\AbstractOperation;
use China\Math\Number\Formatter;


/**
 * ^ 次方
 * Class SquareOperation
 * @package China\Math\Calculation\Adapter
 */
class SquareOperation extends AbstractOperation
{

    /**
     * @param string $left
     * @param string $right
     * @return string
     */
    public function __invoke(string $left, string $right): string
    {
        return Formatter::format(pow($left, intval($right)), $this->scale);
    }

}