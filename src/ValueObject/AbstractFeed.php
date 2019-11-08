<?php declare(strict_types=1);


namespace App\ValueObject;


use InvalidArgumentException;
use SimpleXMLElement;

abstract class AbstractFeed
{
    public function detectUnknownFeedEntry(SimpleXMLElement $element)
    {
        foreach ($element->attributes() as $attribute) {
            $namespace = $attribute->getName();

            if (! property_exists($this, $namespace)) {
                throw new InvalidArgumentException(sprintf('unknown name space provided %s', $namespace));
            }
        }

        foreach ($element as $namespace => $value) {
            if ($element->getName() === $namespace) {
                continue;
            }
            if (! property_exists($this, $namespace)) {
                throw new InvalidArgumentException(sprintf('unknown name space provided %s', $namespace));
            }
        }
    }
}
