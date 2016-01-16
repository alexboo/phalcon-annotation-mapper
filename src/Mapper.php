<?php

namespace Alexboo\AnnotationMapper;


abstract class Mapper implements MapperInterface
{
    /**
     * The object from which the data are taken
     * @var mixed
     */
    protected $_donator;

    /**
     * List of mapped properties in this object
     * @var Property[] $_properties
     */
    protected $_properties;

    /**Mapping data
     * @param $donator
     */
    public function mapping($donator)
    {
        if (!empty($donator) && (is_object($donator) || is_array($donator))) {
            $this->_donator = $donator;

            $this->_properties = Parser::getInstance()->parse($this);

            $this->onBeforeMapping();

            foreach ($this->_properties as $property) {
                $property->mapping($this, $this->_donator);
            }

            $this->onAfterMapping();

            unset($this->_donator);
            unset($this->_properties);
        }
    }

    /**
     * The method is called before mapping
     */
    protected function onBeforeMapping()
    {
        // nothing doing
    }

    /**
     * The method is called affter mapping
     */
    protected function onAfterMapping()
    {
        // nothing doing
    }

    /**
     * Get the object from which the data are taken
     * @return mixed
     */
    public function getDonator()
    {
        return $this->_donator;
    }


}