<?php
declare(strict_types=1);

namespace ThenLabs\MetaParser;

use Doctrine\Common\Annotations\AnnotationReader;
use Reflector;
use ThenLabs\MetaParser\Exception\NoParserFoundException;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class Parser implements ParserInterface
{
    /**
     * @var ParserInterface[]
     */
    protected $parsers = [];

    public function __construct()
    {
        if (version_compare(phpversion(), '8.0', '>=')) {
            $this->parsers[] = new AttributeParser();
        }

        if (class_exists(AnnotationReader::class)) {
            $this->parsers[] = new AnnotationParser();
        }
    }

    public function getParsers(): array
    {
        return $this->parsers;
    }

    public function setParsers(array $parsers): void
    {
        $this->parsers = $parsers;
    }

    /**
     * @param Reflector $reflector
     * @return Metadata
     * @throws NoParserFoundException
     */
    public function parse(Reflector $reflector): Metadata
    {
        if (empty($this->parsers)) {
            throw new NoParserFoundException();
        }

        $result = [];

        foreach ($this->parsers as $parser) {
            $result[] = $parser->parse($reflector);
        }

        return new MetadataList($result);
    }
}
