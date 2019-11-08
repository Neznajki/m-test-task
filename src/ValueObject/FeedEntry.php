<?php declare(strict_types=1);


namespace App\ValueObject;


use DateTime;
use InvalidArgumentException;
use RuntimeException;
use SimpleXMLElement;
use Throwable;

class FeedEntry extends AbstractFeed
{
    /** @var string */
    protected $id;
    /** @var FeedTitle */
    protected $title;
    /** @var FeedSummary */
    protected $summary;
    /** @var FeedAuthor */
    protected $author;
    /** @var FeedLink[] */
    protected $link = [];
    /** @var DateTime */
    protected $updated;

    public function __construct(SimpleXMLElement $element)
    {

        if (empty($element->id)) {
            throw new RuntimeException('id should be not empty');
        }
        $this->id = (string)$element->id;

        try {
            $this->detectUnknownFeedEntry($element);
            if (empty($element->title)) {
                throw new RuntimeException('title should be not empty');
            }

            if (empty($element->summary)) {
                throw new RuntimeException('summary should be not empty');
            }

            if (empty($element->author)) {
                throw new RuntimeException('author should be not empty');
            }

            if (empty($element->updated)) {
                throw new RuntimeException('updated should be not empty');
            }

            $this->title   = new FeedTitle($element->title);
            $this->summary = new FeedSummary($element->summary);
            $this->author  = new FeedAuthor($element->author);

            $this->updated = new DateTime((string)$element->updated);
            if ($this->updated === null) {
                throw new InvalidArgumentException(sprintf('updated should be valid date time %s', $element->updated));
            }

            if (property_exists($element, 'link')) {
                foreach ($element->link as $item) {
                    $this->link[] = new FeedLink($item);
                }
            }
        } catch (Throwable $exception) {
            throw new RuntimeException(
                sprintf('error in %s with message %s', $this->id, $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return FeedTitle
     */
    public function getTitle(): FeedTitle
    {
        return $this->title;
    }

    /**
     * @return FeedSummary
     */
    public function getSummary(): FeedSummary
    {
        return $this->summary;
    }

    /**
     * @return FeedAuthor
     */
    public function getAuthor(): FeedAuthor
    {
        return $this->author;
    }

    /**
     * @return FeedLink[]
     */
    public function getLinks(): array
    {
        return $this->link;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }
}
