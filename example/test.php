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
require_once '../src/cast/FloatCast.php';

// Mapping examples

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



$example = new Example();

$example->mapping($donator);

var_dump($example);


// Set default precision for all properties with float type

\Alexboo\AnnotationMapper\Cast\Float::setDefaultPrecision(1);

class Example3 extends \Alexboo\AnnotationMapper\Mapper
{
    /**
     * @var float $field1
     * @Mapped(type="float")
     */
    public $field1;
    /**
     * @var float $field2
     * @Mapped(type="float")
     */
    public $field2;
}

$example = new Example3();
$example->mapping([
    'field1' => '15.123456',
    'field2' => '987.654123',
]);

var_dump($example);

// Disabled/enabled trim string data

class Example4 extends \Alexboo\AnnotationMapper\Mapper
{
    /**
     * @Mapped(type="string", uppercase="true")
     */
    public $field1;
    /**
     * @Mapped(type="string")
     */
    public $field2;
}

\Alexboo\AnnotationMapper\Cast\StringCast::isTrim(false);

$example = new Example4();
$example->mapping([
    'field1' => '   asdasd  asdasdasd   ',
    'field2' => '        ',
]);

var_dump($example);

\Alexboo\AnnotationMapper\Cast\StringCast::isTrim(true);

$example = new Example4();
$example->mapping([
    'field1' => '   asdasd  asdasdasd   ',
    'field2' => '        ',
]);

var_dump($example);

// Custom custer

/**
 * Cast all data to "blabla" string
 * Class BlaBlaCaster
 */
class BlaBlaCaster extends \Alexboo\AnnotationMapper\Cast\CastAbstract
{
    public function cast($value) {
        return "blabla";
    }
}

class Example5 extends \Alexboo\AnnotationMapper\Mapper
{
    /**
     * @Mapped(type="BlaBlaCaster")
     */
    public $field1;
    /**
     * @Mapped(type="\Alexboo\AnnotationMapper\Cast\Integer")
     */
    public $field2;
}

$example = new Example5();
$example->mapping([
    'field1' => 'Cool!',
    'field2' => 123213213,
]);

var_dump($example);