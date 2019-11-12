<?php
/**
 * AbstractOperation
 *
 * @package   PickBean
 * @author    Monkey  <Monkey@dm-miniprogram.com>
 * @copyright Copyright (C) 2019 Monkey
 */
namespace China\Math\Calculation;


/**
 * Class AbstractOperation
 * @package China\Math\Calculation
 */
abstract class AbstractOperation implements OperationInterface
{

    /**
     * @var int
     */
    protected $scale;

    /**
     * AbstractOperation constructor.
     * @param int $scale
     */
    public function __construct(int $scale = 2)
    {
        $this->scale = $scale;
    }

}