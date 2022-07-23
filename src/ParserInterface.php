<?php
declare(strict_types=1);

namespace ThenLabs\MetaParser;

use Reflector;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
interface ParserInterface
{
    /**
     * @param \ReflectionClass|\ReflectionFunction|\ReflectionMethod|\ReflectionProperty $reflector
     * @return Metadata
     */
    public function parse(Reflector $reflector): Metadata;
}
