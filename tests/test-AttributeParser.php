<?php

use ThenLabs\MetaParser\AttributeParser;
use ThenLabs\MetaParser\Tests\MyAttribute;

testCase(function () {
    setUp(function () {
        $this->parser = new AttributeParser();
    });

    test(function () {
        $obj = new class {
            #[MyAttribute(data1: 'value1')]
            protected $myProperty;
        };

        $class = get_class($obj);
        $result = $this->parser->parse($class, 'myProperty');

        $this->assertFalse($result->has('AnotherAttributeClass'));
        $this->assertTrue($result->has(MyAttribute::class));
        $this->assertEquals('value1', $result->get(MyAttribute::class)->get('data1'));
    });
});
