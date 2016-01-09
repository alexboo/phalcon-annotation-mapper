<?php

namespace Alexboo\AnnotationMapper;


abstract class Mapper implements MapperInterface
{
    public function mapping($donator)
    {
        $parser = Parser::getInstance();

        $properties = $parser->parse($this);

        foreach ($properties as $property) {
            $property->mapping($this, $donator);
        }
    }
}