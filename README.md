
# MetaParser

Extract metadata from attributes and/or annotations.

#### If you like this project gift us a ⭐.

<hr />

## Installation.

    composer require thenlabs/meta-parser dev-main

## Usage example.

```php
/**
 * @MyMetadata(data1="value1")
 */
#[MyMetadata(data1: 'value2')]
class MyClass
{
}

$myClass = new ReflectionClass(MyClass::class);

/**
 * Reading from annotations only.
 */
$annotationParser = new ThenLabs\MetaParser\AnnotationParser();
$annotationParserResult = $annotationParser->parse($myClass);

$annotationParserResult->get(MyMetadata::class)->get('data1') === 'value1'; // true

/**
 * Reading from attributes only.
 */
$attributeParser = new ThenLabs\MetaParser\AttributeParser();
$attributeParserResult = $attributeParser->parse($myClass);

$attributeParserResult->get(MyMetadata::class)->get('data1') === 'value2'; // true

/**
 * Reading both.
 */
$parser = new ThenLabs\MetaParser\Parser();
$parserResult = $parser->parse($myClass);

// this returns true becouse attributes override annotations.
$parserResult->get(MyMetadata::class)->get('data1') === 'value2';
```

### Highlights about `ThenLabs\MetaParser\Parser` class.

#### 1. For read annotations it's necessary to install [Doctrine Annotations](https://www.doctrine-project.org/projects/doctrine-annotations/en/1.13/index.html):

    $ composer require doctrine/annotations

#### 2. The attribute parser require a PHP version grater than 8.0.
#### 3. The `parse()` methods accept an instance of `Reflector`, so that, for parse a method of a class(for example), you can use a `ReflectionMethod` instance.

## Development.

Clone this repository and install the Composer dependencies.

    $ composer install

### Running the tests.

All the tests of this project was written with our testing framework [PyramidalTests][pyramidal-tests] wich is based on [PHPUnit][phpunit].

Run tests:

    $ composer test

[phpunit]: https://phpunit.de
[pyramidal-tests]: https://github.com/thenlabs/pyramidal-tests
