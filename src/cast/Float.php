<?php

namespace Alexboo\AnnotationMapper\Cast;

/**
 * Cast data to float
 * Class Float
 * @package Alexboo\AnnotationMapper\Cast
 */
class Float extends CastAbstract
{
    protected $_precision = null;

    protected static $_defaultPrecision;

    /**
     * Set annotation to cast object. It need for get params specified in annotation
     * @param \Phalcon\Annotations\Annotation $anatation
     */
    public function setData(\Phalcon\Annotations\Annotation $anatation)
    {
        $params = $anatation->getArguments();

        if (isset($params['precision'])) {
            $this->_precision = (int) $params['precision'];
        }
    }

    /**
     * Cast value to float
     * @param $value
     * @return float|int
     */
    public function cast($value)
    {
        if ($this->_precision === null && self::$_defaultPrecision !== null) {
            $this->_precision = self::$_defaultPrecision;
        }

        if (is_scalar($value)) {
            $value = (float) $value;
            if ($this->_precision != null) {
                $value = round($value, $this->_precision);
            }
            return $value;
        }

        return 0;
    }

    /**
     * Set default precision
     * @param $precision
     */
    public static function setDefaultPrecision($precision)
    {
        if (!empty($precision)) {
            self::$_defaultPrecision = (int) $precision;
        }
    }
}