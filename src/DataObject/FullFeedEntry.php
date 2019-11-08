<?php declare(strict_types=1);


namespace App\DataObject;


use App\Entity\ExternalId;
use App\Entity\FeedAuthor;
use App\Entity\FeedLink;
use App\Entity\FeedSummary;
use App\Entity\FeedTitle;

class FullFeedEntry
{
    /** @var ExternalId */
    protected $externalId;
    /** @var FeedAuthor */
    protected $feedAuthor;
    /** @var FeedTitle */
    protected $feedTitle;
    /** @var FeedSummary */
    protected $feedSummary;
    /** @var FeedLink[] */
    protected $feedLinks = [];

    /**
     * FullFeedEntry constructor.
     * @param ExternalId $externalId
     * @param FeedTitle $feedTitle
     * @param FeedSummary $feedSummary
     * @param FeedLink[] $feedLinks
     */
    public function __construct(ExternalId $externalId, FeedTitle $feedTitle, FeedSummary $feedSummary, array $feedLinks)
    {
        $this->externalId  = $externalId;
        $this->feedTitle   = $feedTitle;
        $this->feedSummary = $feedSummary;

        foreach ($feedLinks as $feedLink) {
            $this->addFeedLink($feedLink);
        }
    }

    /**
     * @return ExternalId
     */
    public function getExternalId(): ExternalId
    {
        return $this->externalId;
    }

    /**
     * @return FeedAuthor
     */
    public function getFeedAuthor(): FeedAuthor
    {
        return $this->feedAuthor;
    }

    /**
     * @return FeedTitle
     */
    public function getFeedTitle(): FeedTitle
    {
        return $this->feedTitle;
    }

    /**
     * @return FeedSummary
     */
    public function getFeedSummary(): FeedSummary
    {
        return $this->feedSummary;
    }

    /**
     * @return FeedLink[]
     */
    public function getFeedLinks(): array
    {
        return $this->feedLinks;
    }

    /**
     * @param FeedLink $feedLink
     */
    protected function addFeedLink(FeedLink $feedLink)
    {
        $this->feedLinks[] = $feedLink;
    }
}
