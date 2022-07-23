<?php
declare(strict_types=1);

namespace ThenLabs\MetaParser;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class MetadataList extends Metadata
{
    public function has(string $name): bool
    {
        foreach ($this->data as $result) {
            if (true === $result->has($name)) {
                return true;
            }
        }

        return false;
    }

    public function get(string $name)
    {
        $result = null;

        foreach ($this->data as $result) {
            if ($result->has($name)) {
                return $result->get($name);
            }
        }

        return $result;
    }
}
