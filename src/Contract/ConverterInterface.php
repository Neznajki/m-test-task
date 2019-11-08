<?php


namespace App\Contract;


use App\Entity\ExternalId;
use App\Entity\FeedAuthor;
use App\Entity\FeedLink;
use App\Entity\FeedSummary;
use App\Entity\FeedTitle;
use App\ValueObject\AbstractFeed;

/**
 * TODO rework to collections for optimal data gathering
 * Interface ConverterInterface
 * @package App\Contract
 */
interface ConverterInterface
{
    /**
     * @param AbstractFeed $abstractFeed
     * @return FeedAuthor|ExternalId|FeedLink|FeedSummary|FeedTitle
     */
    public function convert(AbstractFeed $abstractFeed);
}
