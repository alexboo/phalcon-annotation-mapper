<?php

require_once '../src/MapperInterface.php';
require_once '../src/Mapper.php';
require_once '../src/Parser.php';
require_once '../src/Property.php';
require_once '../src/Reference.php';
require_once '../src/cast/CastInterface.php';
require_once '../src/cast/CastAbstract.php';
require_once '../src/cast/Boolean.php';
require_once '../src/cast/Integer.php';
require_once '../src/cast/String.php';
require_once '../src/cast/Float.php';

class Example extends \Alexboo\AnnotationMapper\Mapper
{
    /**
     * @Mapped(property="priceOut", type="float", precision=2)
     */
    public $price;

    /**
     * @Mapped(type="integer")
     */
    protected $count;

    /**
     * @Mapped(type="float[]", precision=2)
     */
    public $array;

    /**
     * @Mapped(type="Example2[]")
     */
    public $object;

    public function setCount($value) {
        $this->count = $value;
    }
}

class Example2 extends \Alexboo\AnnotationMapper\Mapper
{
    /**
     * @Mapped(type="integer")
     */
    public $property1;

    /**
     * @Mapped(type="float", precision=2)
     */
    public $property2;
}

$donator = [
    'priceOut' => '1000.50000',
    'count' => 100,
    'array' => ['1.222','2.333','3.400000'],
    'object' => [[
        'property1' => '1000.500',
        'property2' => '2000.500',
    ]]
];

$example = new Example();

$example->mapping($donator);

var_dump($example);

$donator = new stdClass();
$donator->priceOut = '2000.50000';
$donator->count = 200;
$donator->array = [4,5,6];
$donator->object = [[
    'property1' => '1000.500',
    'property2' => '2000.500',
]];


$example = new Example();

$example->mapping($donator);

var_dump($example);
