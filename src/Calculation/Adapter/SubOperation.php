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
 * Class SubOperation
 * @package China\Math\Calculation\Adapter
 */
class SubOperation extends AbstractOperation
{

    /**
     * @param string $left
     * @param string $right
     * @return string
     */
    public function __invoke(string $left, string $right): string
    {
        return Formatter::format($left - $right, $this->scale);
    }

}