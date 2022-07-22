<?php
declare(strict_types=1);

namespace ThenLabs\MetaParser;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
interface ParserInterface
{
    public function parse($subject, ?string $member = null): Metadata;
}
