<?php

namespace Alexboo\AnnotationMapper\Cast;

/**
 * Abstract cast class
 * Class CastAbstract
 * @package Alexboo\AnnotationMapper\Cast
 */
abstract class CastAbstract implements CastInterface
{

    /**
     * Set annotation to cast object. It need for get params specified in annotation
     * @param \Phalcon\Annotations\Annotation $anatation
     */
    public function setData(\Phalcon\Annotations\Annotation $anatation)
    {

    }

    /**
     * Cast value to specified type
     * @param $value
     * @return mixed
     */
    public function cast($value)
    {
        return $value;
    }
}