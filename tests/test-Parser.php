<?php

use ThenLabs\MetaParser\Parser;
use ThenLabs\MetaParser\Tests\MyAnnotation;
use ThenLabs\MetaParser\Tests\MyClass;

test(function () {
    $parser = new Parser();
    $result = $parser->parse(new ReflectionClass(MyClass::class));

    $this->assertEquals('value1000', $result->get(MyAnnotation::class)->get('data1'));
    $this->assertNull($result->get(MyAnnotation::class)->get('data2'));
});
