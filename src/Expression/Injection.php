<?php
/**
 * Injection
 *
 * @package   PickBean
 * @author    Monkey  <Monkey@dm-miniprogram.com>
 * @copyright Copyright (C) 2019 Monkey
 */
namespace China\Math\Expression;


/**
 * Class Injection
 * @package China\Math\Expression
 */
class Injection
{

    /**
     * @var string
     */
    private $symbol;

    /**
     * @var array
     */
    private $bind_data;

    /**
     * Injection constructor.
     * @param string $symbol
     */
    public function __construct(string $symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @param int $weight
     * @param string $operation
     * @return Injection
     */
    public function bindOperation(int $weight, ?string $operation = null): self
    {
        $this->bind_data =  array(
            array(
                $this->symbol => $weight,
            ),
            array(
                $this->symbol => $operation,
            )
        );
        return $this;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @return array
     */
    public function getBindData(): array
    {
        return $this->bind_data;
    }

}