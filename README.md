# Phalcon annotation mapper

Filling properties of the object based on another entity or associative array using data description annotations

### Install

You can install it using the composer
 
```
composer require alexboo/phalcon-annotation-mapper
```

### Examples
```
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

```