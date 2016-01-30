<?php

namespace Alexboo\AnnotationMapper\Cast;
use Alexboo\AnnotationMapper\Reference;

/**
 * Cast data to string
 * Class String
 * @package Alexboo\AnnotationMapper\Cast
 */
class String extends CastAbstract
{
    protected $_trim = null;

    protected $_uppercase = false;

    protected $_lowercase = false;

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

        if (isset($params[Reference::PARAM_TRIM])) {
            $this->_trim = filter_var($params[Reference::PARAM_TRIM], FILTER_VALIDATE_BOOLEAN);
        }

        if (isset($params[Reference::PARAM_UPPERCASE])) {
            $this->_uppercase = filter_var($params[Reference::PARAM_UPPERCASE], FILTER_VALIDATE_BOOLEAN);
        }

        if (isset($params[Reference::PARAM_LOWERCASE])) {
            $this->_lowercase = filter_var($params[Reference::PARAM_LOWERCASE], FILTER_VALIDATE_BOOLEAN);
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

            if ($this->_uppercase === true) {
                $value = \Phalcon\Text::upper($value);
            } elseif ($this->_lowercase === true) {
                $value = \Phalcon\Text::lower($value);
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