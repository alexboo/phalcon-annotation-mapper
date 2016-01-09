<?php

namespace Alexboo\AnnotationMapper\Cast;

/**
 * Cast data to string
 * Class String
 * @package Alexboo\AnnotationMapper\Cast
 */
class String extends CastAbstract
{
    /**
     * Cast value to string
     * @param $value
     * @return string
     */
    public function cast($value)
    {
        if (is_scalar($value)) {
            return (string) $value;
        }

        return '';
    }
}