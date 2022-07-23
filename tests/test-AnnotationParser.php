<?php

require_once __DIR__.'/MyAnnotation.php';

use ThenLabs\MetaParser\AnnotationParser;
use ThenLabs\MetaParser\Tests\MyAnnotation;
use ThenLabs\MetaParser\Tests\MyClass;

/**
 * @MyAnnotation(data1="blue")
 */
function myAnnotatedFunction()
{
}

testCase(function () {
    setUp(function () {
        $this->parser = new AnnotationParser();
    });

    test(function () {
        $myAnnotatedFunction = new ReflectionFunction('myAnnotatedFunction');
        $result = $this->parser->parse($myAnnotatedFunction);

        $this->assertTrue($result->has(MyAnnotation::class));
        $this->assertEquals('blue', $result->get(MyAnnotation::class)->get('data1'));
    });

    test(function () {
        $obj = new class {
            /**
             * @MyAnnotation(data1="value1")
             */
            protected $myProperty;
        };

        $myProperty = new ReflectionProperty($obj, 'myProperty');
        $result = $this->parser->parse($myProperty);

        $this->assertFalse($result->has('AnotherAnnotationClass'));
        $this->assertTrue($result->has(MyAnnotation::class));
        $this->assertEquals('value1', $result->get(MyAnnotation::class)->get('data1'));
    });

    test(function () {
        $obj = new class {
            /**
             * @MyAnnotation(data1="value11", data2={"name"="Andy", "lastName"="Navarro"})
             */
            public function myMethod()
            {
            }
        };

        $myMethod = new ReflectionMethod($obj, 'myMethod');
        $result = $this->parser->parse($myMethod);

        $this->assertTrue($result->has(MyAnnotation::class));
        $this->assertEquals('value11', $result->get(MyAnnotation::class)->get('data1'));
        $this->assertEquals(
            ['name' => 'Andy', 'lastName' => 'Navarro'],
            $result->get(MyAnnotation::class)->get('data2')
        );
    });

    test(function () {
        $obj = new MyClass();

        $result = $this->parser->parse(new ReflectionClass($obj));

        $this->assertEquals('value11', $result->get(MyAnnotation::class)->get('data1'));
    });
});
