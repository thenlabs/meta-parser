<?php

namespace ThenLabs\MetaParser\Tests;

/**
 * @MyAnnotation(data1="value11")
 */
#[MyAttribute(data1: 'value11', data2: 'value2')]
#[MyAnnotation(data1: 'value1000')]
class MyClass
{
}
