<?php declare(strict_types=1);


namespace App\ValueObject;


use InvalidArgumentException;
use SimpleXMLElement;

class FeedAuthor extends AbstractFeed
{
    /** @var string */
    protected $name;
    /** @var string */
    protected $uri;
    /** @var string|null */
    protected $email;

    public function __construct(SimpleXMLElement $element)
    {
        $this->detectUnknownFeedEntry($element);

        if (empty($element->name)) {
            throw new InvalidArgumentException('author should have name');
        }

        if (empty($element->uri)) {
            throw new InvalidArgumentException('author should have uri');
        }

        $this->name = (string)$element->name;
        $this->uri = (string)$element->uri;

        if (! empty($element->email)) {
            $this->email = (string)$element->email;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
}
