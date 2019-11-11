<?php
/**
 * Formatter
 *
 * @package   PickBean
 * @author    Monkey  <Monkey@dm-miniprogram.com>
 * @copyright Copyright (C) 2019 Monkey
 */
namespace Math\Number;


/**
 * Class Formatter
 * @package Math\Number
 */
final class Formatter {

    /**
     * @param int|float $number
     * @param int $decimals
     * @return string
     */
    final public static function format($number, int $decimals = 2): string {
        return number_format($number, $decimals, '.', '');
    }

    /**
     * @param $number
     * @param int $decimals
     * @return string
     */
    final public static function formatWithDiv100($number, int $decimals = 2): string {
        return self::format($number / 100, $decimals);
    }

    /**
     * @param $number
     * @param int $decimals
     * @return string
     */
    final public static function formatWithDiv10($number, int $decimals = 2): string {
        return self::format($number / 10, $decimals);
    }

    /**
     * @param float $number
     * @return int
     */
    final public static function formatWithMul100(float $number): int {
        return intval(bcmul($number, 100));
    }

}
