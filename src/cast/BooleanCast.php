<?php

namespace Alexboo\AnnotationMapper\Cast;

/**
 * Cast data to boolean
 * Class Boolean
 * @package Alexboo\AnnotationMapper\Cast
 */
class BooleanCast extends CastAbstract
{
    public function cast($value)
    {
        if (is_scalar($value)) {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        return false;
    }
}