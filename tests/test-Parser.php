<?php

use ThenLabs\MetaParser\Parser;
use ThenLabs\MetaParser\Tests\MyAnnotation;
use ThenLabs\MetaParser\Tests\MyClass;

test(function () {
    $parser = new Parser();
    $result = $parser->parse(new ReflectionClass(MyClass::class));

    $data1Expected = version_compare(phpversion(), '8.0', '<') ? 'value11' : 'value1000';

    $this->assertEquals($data1Expected, $result->get(MyAnnotation::class)->get('data1'));
    $this->assertNull($result->get(MyAnnotation::class)->get('data2'));
});
