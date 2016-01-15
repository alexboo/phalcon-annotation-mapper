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


\Alexboo\AnnotationMapper\Cast\Float::setDefaultPrecision(1);

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
     * @Mapped(type="float[]")
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
    public $propertyOne;

    /**
     * @Mapped(type="float")
     */
    public $propertyTwo;

    /**
     * @Mapped(type="string")
     */
    public $propertyThree;
}

$donator = [
    'priceOut' => '1000.51000',
    'count' => 100,
    'array' => ['1.222','2.333','3.400000'],
    'object' => [[
        'propertyOne' => '1000.500',
        'propertyTwo' => '2000.500',
        'propertyThree' => ' aaaddd '
    ]]
];

$example = new Example();

$example->mapping($donator);


var_dump($example);

$donator = new stdClass();
$donator->priceOut = '2000.52000';
$donator->count = 200;
$donator->array = [4,5,6];
$donator->object = [[
    'propertyOne' => '1000.520',
    'propertyTwo' => '2000.520',
    'propertyThree' => ' aaaddd '
]];

\Alexboo\AnnotationMapper\Cast\String::isTrim(false);

$example = new Example();

$example->mapping($donator);

var_dump($example);


