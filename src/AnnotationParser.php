<?php
declare(strict_types=1);

namespace ThenLabs\MetaParser;

use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;
use Reflector;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class AnnotationParser implements ParserInterface
{
    public function parse(Reflector $reflector): Metadata
    {
        $data = [];
        $annotations = [];
        $reader = new AnnotationReader();

        if ($reflector instanceof ReflectionProperty) {
            $annotations = $reader->getPropertyAnnotations($reflector);
        } elseif ($reflector instanceof ReflectionMethod) {
            $annotations = $reader->getMethodAnnotations($reflector);
        } elseif ($reflector instanceof ReflectionClass) {
            $annotations = $reader->getClassAnnotations($reflector);
        } elseif ($reflector instanceof ReflectionFunction) {
            $annotations = $reader->getFunctionAnnotations($reflector);
        }

        foreach ($annotations as $annotation) {
            $annotationClass = get_class($annotation);
            $data[$annotationClass] = new Metadata($annotation);
        }

        return new Metadata($data);
    }
}
