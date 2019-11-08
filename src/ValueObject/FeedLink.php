<?php declare(strict_types=1);


namespace App\ValueObject;


use App\Contract\ContainsRelInterface;
use App\Contract\ContainsTypeInterface;
use InvalidArgumentException;
use SimpleXMLElement;

class FeedLink extends AbstractFeed implements ContainsTypeInterface, ContainsRelInterface
{
    /** @var string */
    protected $rel;
    /** @var string */
    protected $type;
    /** @var string */
    protected $href;

    public function __construct(SimpleXMLElement $element)
    {
        $this->detectUnknownFeedEntry($element);

        if (empty($element['rel'])) {
            throw new InvalidArgumentException('link attribute rel is required');
        }

        if (empty($element['type'])) {
            throw new InvalidArgumentException('link attribute type is required');
        }

        if (empty($element['href'])) {
            throw new InvalidArgumentException('link attribute href is required');
        }

        $this->rel = (string)$element['rel'];
        $this->type = (string)$element['type'];
        $this->href = (string)$element['href'];
    }

    /**
     * @return string
     */
    public function getRel(): string
    {
        return $this->rel;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }
}
