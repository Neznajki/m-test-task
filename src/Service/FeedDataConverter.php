<?php declare(strict_types=1);


namespace App\Service;


use App\DataObject\FullFeedEntry;
use App\Service\Converter\FeedExternalIdConverterService;
use App\Service\Converter\FeedLinkConverterService;
use App\Service\Converter\FeedSummaryConverterService;
use App\Service\Converter\FeedTitleConverterService;
use App\ValueObject\FeedEntry;
use Doctrine\ORM\ORMException;

class FeedDataConverter
{
    /** @var FeedExternalIdConverterService */
    protected $feedEntityConverterService;
    /** @var FeedTitleConverterService */
    protected $feedTitleConverterService;
    /** @var FeedSummaryConverterService */
    protected $feedSummaryConverterService;
    /** @var FeedLinkConverterService */
    protected $linkConverterService;

    public function __construct(
        FeedExternalIdConverterService $feedEntityConverterService,
        FeedTitleConverterService $feedTitleConverterService,
        FeedSummaryConverterService $feedSummaryConverterService,
        FeedLinkConverterService $linkConverterService
    )
    {
        $this->feedEntityConverterService = $feedEntityConverterService;
        $this->feedTitleConverterService = $feedTitleConverterService;
        $this->feedSummaryConverterService = $feedSummaryConverterService;
        $this->linkConverterService = $linkConverterService;
    }

    /**
     * @param FeedEntry[] $feedValueObjectCollection
     * @return FullFeedEntry[]
     * @throws ORMException
     */
    public function convertEntryObjectToEntity(array $feedValueObjectCollection): array
    {
        $feedEntityCollection = [];

        foreach ($feedValueObjectCollection as $entry) {
            $fullDataEntity = $this->getFullDataEntry($entry);

            $feedEntityCollection[] = $fullDataEntity;
        }

        return $feedEntityCollection;
    }

    /**
     * @param FeedEntry $entry
     * @return FullFeedEntry
     * @throws ORMException
     */
    protected function getFullDataEntry(FeedEntry $entry): FullFeedEntry
    {
        $externalId = $this->feedEntityConverterService->convert($entry);
        $title      = $this->feedTitleConverterService->convert($entry->getTitle(), $externalId);
        $summary    = $this->feedSummaryConverterService->convert($entry->getSummary(), $externalId);

        $links = [];

        foreach ($entry->getLinks() as $link) {
            $links[] = $this->linkConverterService->convert($link, $externalId);
        }

        $fullDataEntity = new FullFeedEntry(
            $externalId,
            $title,
            $summary,
            $links
        );

        return $fullDataEntity;
    }
}
