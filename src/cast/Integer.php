<?php

namespace Alexboo\AnnotationMapper\Cast;

/**
 * Cast data to integer
 * Class Integer
 * @package Alexboo\AnnotationMapper\Cast
 */
class Integer extends CastAbstract
{
    /**
     * Cast value to integer
     * @param $value
     * @return int
     */
    public function cast($value)
    {
        if (is_scalar($value)) {
            return (int) $value;
        }

        return 0;
    }
}