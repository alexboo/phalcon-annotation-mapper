<?php
/**
 * Created by PhpStorm.
 * User: alexboo
 * Date: 04.08.16
 * Time: 22:07
 */

namespace Alexboo\AnnotationMapper\Cast;


use Alexboo\AnnotationMapper\Reference;

class DoubleCast extends CastAbstract
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

        if (isset($params[Reference::PARAM_PRECISION])) {
            $this->_precision = (int)$params[Reference::PARAM_PRECISION];
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
            $value = (double)$value;
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
            self::$_defaultPrecision = (int)$precision;
        }
    }
}