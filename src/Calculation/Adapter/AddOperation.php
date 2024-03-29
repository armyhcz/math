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


/**
 * Class AddOperation
 * @package China\Math\Calculation\Adapter
 */
class AddOperation extends AbstractOperation
{

    /**
     * @param string $left
     * @param string $right
     * @return string
     */
    public function __invoke(string $left, string $right): string
    {
        return bcadd($left, $right, $this->scale);
    }

}