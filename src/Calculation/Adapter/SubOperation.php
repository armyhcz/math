<?php
/**
 * AddOperation
 *
 * @package   PickBean
 * @author    Monkey  <Monkey@dm-miniprogram.com>
 * @copyright Copyright (C) 2019 Monkey
 */
namespace Math\Calculation\Adapter;


use Math\Calculation\AbstractOperation;
use Math\Number\Formatter;


/**
 * Class AddOperation
 * @package Math\Calculation\Adapter
 */
class SubOperation extends AbstractOperation {

    /**
     * @param string $left
     * @param string $right
     * @return string
     */
    public function __invoke(string $left, string $right): string {
        return Formatter::format($left - $right, $this->scale);
    }

}