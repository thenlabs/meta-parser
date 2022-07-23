<?php

if (version_compare(phpversion(), '8.0', '<')) {
    return;
}

use ThenLabs\MetaParser\AttributeParser;
use ThenLabs\MetaParser\Tests\MyAttribute;
use ThenLabs\MetaParser\Tests\MyClass;

#[MyAttribute(color: 'red')]
function myFunction()
{
}

testCase(function () {
    setUp(function () {
        $this->parser = new AttributeParser();
    });

    test(function () {
        $obj = new class {
            #[MyAttribute(data1: 'value1')]
            protected $myProperty;
        };

        $myProperty = new ReflectionProperty($obj, 'myProperty');
        $result = $this->parser->parse($myProperty);

        $this->assertFalse($result->has('AnotherAttributeClass'));
        $this->assertTrue($result->has(MyAttribute::class));
        $this->assertEquals('value1', $result->get(MyAttribute::class)->get('data1'));
    });

    test(function () {
        $myFunction = new ReflectionFunction('myFunction');
        $result = $this->parser->parse($myFunction);

        $this->assertTrue($result->has(MyAttribute::class));
        $this->assertEquals('red', $result->get(MyAttribute::class)->get('color'));
    });

    test(function () {
        $obj = new class {
            #[MyAttribute(data1: 'value1')]
            public function myMethod()
            {
            }
        };

        $myMethod = new ReflectionMethod($obj, 'myMethod');
        $result = $this->parser->parse($myMethod);

        $this->assertFalse($result->has('AnotherAttributeClass'));
        $this->assertTrue($result->has(MyAttribute::class));
        $this->assertEquals('value1', $result->get(MyAttribute::class)->get('data1'));
    });

    test(function () {
        $obj = new MyClass();

        $result = $this->parser->parse(new ReflectionClass($obj));

        $this->assertTrue($result->has(MyAttribute::class));
        $this->assertEquals('value11', $result->get(MyAttribute::class)->get('data1'));
        $this->assertEquals('value2', $result->get(MyAttribute::class)->get('data2'));
    });
});
