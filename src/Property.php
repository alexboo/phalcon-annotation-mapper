<?php

namespace Alexboo\AnnotationMapper;

use Alexboo\AnnotationMapper\Cast\CastInterface;

/**
 * Class with annotation parameters
 * Class Property
 * @package Alexboo\AnnotationMapper
 */
class Property
{
    // data type
    protected $_type;
    // recipient property
    protected $_property;
    // donator property
    protected $_mappingProperty;
    /**
     * Annotation data
     * @var \Phalcon\Annotations\Annotation
     */
    protected $_annotation;
    /**
     * If type specified like array, it equal true
     * @var bool
     */
    protected $_isArray = false;

    public function __construct($property, \Phalcon\Annotations\Annotation $annotation)
    {
        $this->_property = $property;

        $params = $annotation->getArguments();

        if (isset($params['type'])) {
            if (stripos($params['type'], '[]') !== false) {
                $this->_isArray = true;
                $params['type'] = rtrim($params['type'], '[]');
            }
            $this->_type = $params['type'];
        }

        if (isset($params['property'])) {
            $this->_mappingProperty = $params['property'];
        } else {
            $this->_mappingProperty = $property;
        }

        $this->_annotation = $annotation;
    }

    /**
     * Mapped value from donator to recipient object
     * @param $recipient
     * @param $donator
     */
    public function mapping($recipient, $donator)
    {
        if (is_object($recipient)) {
            $value = $this->getValue($donator);
            $setMethod = 'set' . ucfirst($this->_property);
            if (method_exists($recipient, $setMethod)) {
                $recipient->{$setMethod}($value);
            } else if (property_exists($recipient, $this->_property)) {
                $recipient->{$this->_property} = $value;
            }
        }
    }

    /**
     * Get value for property from donator
     * @param $donator
     * @return MapperInterface|array
     */
    protected function getValue($donator)
    {
        $value = null;

        if (is_object($donator)) {
            $getMethod = 'get' . ucfirst($this->_mappingProperty);
            if (method_exists($donator, $getMethod)) {
                $value = $donator->{$getMethod}();
            } else if (property_exists($donator, $this->_mappingProperty)){
                $value = $donator->{$this->_mappingProperty};
            }
        } else if (is_array($donator)) {
            if (isset($donator[$this->_mappingProperty])) {
                $value = $donator[$this->_mappingProperty];
            }
        }

        if ($this->_isArray) {
            $array = [];
            foreach ($value as $row) {
                $array[] = $this->cast($row);
            }

            return $array;
        }

        return $this->cast($value);
    }

    /**
     * Cast value to specified type
     * @param $value
     * @return MapperInterface
     */
    protected function cast($value)
    {
        if (!empty($this->_type)) {

            if (class_exists($this->_type)) {
                $object  = new $this->_type();
                if ($object instanceof MapperInterface) {
                    $object->mapping($value);
                    $value = $object;
                }
            } else {
                $castClass = 'Alexboo\\AnnotationMapper\\Cast\\'. ucfirst($this->_type);
                if (class_exists($castClass)) {
                    /**
                     * @var CastInterface $caster
                     */
                    $caster = new $castClass();
                    if ($caster instanceof CastInterface) {
                        $caster->setData($this->_annotation);
                        return $caster->cast($value);
                    }
                }
            }
        }

        return $value;
    }
}