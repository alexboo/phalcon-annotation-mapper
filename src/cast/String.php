<?php

namespace Alexboo\AnnotationMapper\Cast;

/**
 * Cast data to string
 * Class String
 * @package Alexboo\AnnotationMapper\Cast
 */
class String extends CastAbstract
{
    protected $_trim = null;

    /**
     * @var bool $_trim
     */
    protected static $_defaultTrim = true;

    /**
     * Set annotation to cast object. It need for get params specified in annotation
     * @param \Phalcon\Annotations\Annotation $anatation
     */
    public function setData(\Phalcon\Annotations\Annotation $anatation)
    {
        $params = $anatation->getArguments();

        if (isset($params['trim'])) {
            $this->_trim = (bool) $params['trim'];
        }
    }

    /**
     * Cast value to string
     * @param $value
     * @return string
     */
    public function cast($value)
    {
        if ($this->_trim === null && self::$_defaultTrim !== null) {
            $this->_trim = self::$_defaultTrim;
        }

        if (is_scalar($value)) {
            $value =  (string) $value;
            if ($this->_trim === true) {
                $value = trim($value);
            }

            return $value;
        }

        return '';
    }

    /**
     * Trim value in cast or not
     * @param bool|true $value
     */
    public static function isTrim($trim = true) {
        self::$_defaultTrim = (bool) $trim;
    }
}