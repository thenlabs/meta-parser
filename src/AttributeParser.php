<?php
declare(strict_types=1);

namespace ThenLabs\MetaParser;

use Reflector;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class AttributeParser implements ParserInterface
{
    public function parse(Reflector $reflector): Metadata
    {
        $data = [];

        foreach ($reflector->getAttributes() as $attribute) {
            $data[$attribute->getName()] = new Metadata($attribute);
        }

        return new Metadata($data);
    }
}
