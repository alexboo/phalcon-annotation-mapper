<?php

namespace Alexboo\AnnotationMapper\Cast;

/**
 * Default cast interface
 * Interface CastInterface
 * @package Alexboo\AnnotationMapper\Cast
 */
interface CastInterface
{
    /**
     * Set annotation to cast object. It need for get params specified in annotation
     * @param \Phalcon\Annotations\Annotation $anatation
     */
    public function setData(\Phalcon\Annotations\Annotation $anatation);

    /**
     * Cast value to specified type
     * @param $value
     */
    public function cast($value);
}