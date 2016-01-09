<?php

namespace Alexboo\AnnotationMapper;

use Phalcon\DI;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

/**
 * Pasre annotation from class
 * Class Parser
 * @package Alexboo\AnnotationMapper
 */
class Parser
{
    protected static $_instance;
    protected $adapter = null;

    /**
     * Get instance of Parser
     * @return Parser
     */
    public static function getInstance(){
        if (self::$_instance === null) {
            self::$_instance = new Parser();
        }

        return self::$_instance;
    }

    protected function __construct()
    {
        /**
         * Get annotation parse set to DI
         */
        if (DI::getDefault() && DI::getDefault()->has(Reference::DI_ADAPTER_NAME)) {
            $adapter = DI::getDefault()->get(Reference::DI_ADAPTER_NAME);
            if ($adapter instanceof \Phalcon\Annotations\AdapterInterface) {
                $this->adapter = $adapter;
            }
        }

        /**
         * If annotation pareser not specified use Memory adapter
         */
        if ($this->adapter === null) {
            $this->adapter = new MemoryAdapter();
        }
    }

    /**
     * Parse annotations fo class
     * @param string|object $className
     * @return Property[]|\Phalcon\Annotations\Collection
     */
    public function parse($className)
    {
        $reflector = $this->adapter->get($className);
        $properties = $reflector->getPropertiesAnnotations();

        $_properties = [];

        foreach ($properties as $propertyName => $property) {
            if ($property->has(Reference::ANNOTATION_MAPPED)) {
                $annotation = $property->get(Reference::ANNOTATION_MAPPED);
                $_properties[] = new Property($propertyName, $annotation);
            }
        }

        return $_properties;
    }
}