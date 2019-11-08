<?php declare(strict_types=1);


namespace App\ValueObject;


use App\Contract\ContainsTypeInterface;
use SimpleXMLElement;

class FeedTitle extends AbstractFeed implements ContainsTypeInterface
{
    /** @var string */
    protected $type;
    /** @var string */
    protected $content;

    public function __construct(SimpleXMLElement $element)
    {
        $this->detectUnknownFeedEntry($element);

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
