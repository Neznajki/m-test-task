<?php declare(strict_types=1);


namespace App\ValueObject;


use App\Contract\ContainsTypeInterface;
use InvalidArgumentException;
use SimpleXMLElement;

class FeedSummary extends AbstractFeed implements ContainsTypeInterface
{
    /** @var string */
    protected $type;
    /** @var string */
    protected $content;

    public function __construct(SimpleXMLElement $element)
    {
        $this->detectUnknownFeedEntry($element);

        if (empty($element['type'])) {
            throw new InvalidArgumentException('feed summary field type is required');
        }

        $this->type    = (string)$element['type'];

        $this->content = (string)$element;
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
    public function getContent(): string
    {
        return $this->content;
    }
}
