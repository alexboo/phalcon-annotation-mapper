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

    // recipient
    protected $_recipient;
    // donator
    protected $_donator;

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

        if (isset($params[Reference::ANNOTATION_PROPERTY_TYPE])) {
            if (stripos($params[Reference::ANNOTATION_PROPERTY_TYPE], '[]') !== false) {
                $this->_isArray = true;
                $params[Reference::ANNOTATION_PROPERTY_TYPE] = rtrim($params[Reference::ANNOTATION_PROPERTY_TYPE], '[]');
            }
            $this->_type = $params[Reference::ANNOTATION_PROPERTY_TYPE];
        }

        if (isset($params[Reference::ANNOTATION_PROPERTY])) {
            $this->_mappingProperty = $params[Reference::ANNOTATION_PROPERTY];
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
        $this->_recipient = $recipient;
        $this->_donator = $donator;
        if (is_object($this->_recipient)) {
            $value = $this->getValue();
            $this->setValue($value);
        }
    }

    /**
     * Set value to recipient
     * @param $value
     * @param mixed $recipient
     */
    public function setValue($value, $recipient = null)
    {
        if ($recipient === null) {
            $recipient = $this->_recipient;
        }

        if (is_object($recipient)) {
            $setMethod = 'set' . \Phalcon\Text::camelize($this->_property);
            if (method_exists($recipient, $setMethod)) {
                $recipient->{$setMethod}($value);
            } else if (property_exists($recipient, $this->_property)) {
                $recipient->{$this->_property} = $value;
            }
        } else {
            $recipient[$this->_property] = $value;
        }
    }

    /**
     * Get value for property from donator
     * @param mixed $dontator
     * @return MapperInterface|array
     */
    public function getValue($dontator = null)
    {
        if ($dontator === null) {
            $dontator = $this->_donator;
        }

        $value = null;

        if (is_object($dontator)) {
            $getMethod = 'get' . \Phalcon\Text::camelize($this->_mappingProperty);
            if (method_exists($dontator, $getMethod)) {
                $value = $dontator->{$getMethod}();
            } else if (isset($dontator, $this->_mappingProperty)){
                $value = $dontator->{$this->_mappingProperty};
            }
        } else if (is_array($dontator)) {
            if (isset($dontator[$this->_mappingProperty])) {
                $value = $dontator[$this->_mappingProperty];
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
                } else if ($object instanceof CastInterface) {
                    $value = $object->cast($value);
                } else {
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

    /**
     * Get type of property
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Set type of property
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * Get property name
     * @return mixed
     */
    public function getProperty()
    {
        return $this->_property;
    }

    /**
     * Set property name
     * @param mixed $property
     */
    public function setProperty($property)
    {
        $this->_property = $property;
    }

    /**
     * Get mapping property name
     * @return mixed
     */
    public function getMappingProperty()
    {
        return $this->_mappingProperty;
    }

    /**
     * Set mapping propery name
     * @param mixed $mappingProperty
     */
    public function setMappingProperty($mappingProperty)
    {
        $this->_mappingProperty = $mappingProperty;
    }

    /**
     * Get anotation data
     * @return \Phalcon\Annotations\Annotation
     */
    public function getAnnotation()
    {
        return $this->_annotation;
    }

    /**
     * @return boolean
     */
    public function isIsArray()
    {
        return $this->_isArray;
    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        return $this->_recipient;
    }

    /**
     * @return mixed
     */
    public function getDonator()
    {
        return $this->_donator;
    }

    /**
     * @param mixed $recipient
     */
    public function setRecipient($recipient)
    {
        $this->_recipient = $recipient;
    }

    /**
     * @param mixed $donator
     */
    public function setDonator($donator)
    {
        $this->_donator = $donator;
    }
}