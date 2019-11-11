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


/**
 * Class AddOperation
 * @package Math\Calculation\Adapter
 */
class AddOperation extends AbstractOperation {

    /**
     * @param string $left
     * @param string $right
     * @return string
     */
    public function __invoke(string $left, string $right): string {
        return bcadd($left, $right, $this->scale);
    }

}