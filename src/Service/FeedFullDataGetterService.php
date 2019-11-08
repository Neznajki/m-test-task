<?php declare(strict_types=1);


namespace App\Service;


use App\DataObject\FullFeedEntry;
use App\Repository\ExternalIdRepository;
use App\Repository\FeedLinkRepository;
use App\Repository\FeedSummaryRepository;
use App\Repository\FeedTitleRepository;

class FeedFullDataGetterService
{
    /** @var ExternalIdRepository */
    protected $externalIdRepository;
    /** @var FeedSummaryRepository */
    protected $feedSummaryRepository;
    /** @var FeedTitleRepository */
    protected $feedTitleRepository;
    /** @var FeedLinkRepository */
    protected $feedLinkRepository;

    public function __construct(
        ExternalIdRepository $externalIdRepository,
        FeedSummaryRepository $feedSummaryRepository,
        FeedTitleRepository $feedTitleRepository,
        FeedLinkRepository $feedLinkRepository
    )
    {
        $this->externalIdRepository = $externalIdRepository;
        $this->feedSummaryRepository = $feedSummaryRepository;
        $this->feedTitleRepository = $feedTitleRepository;
        $this->feedLinkRepository = $feedLinkRepository;
    }

    /**
     * just rushing things up
     * @return FullFeedEntry[]
     */
    public function getFullFeedData(): array
    {
        $externalIdList = $this->externalIdRepository->findAll();
        $feedSummaryData = [];
        foreach ($this->feedSummaryRepository->findAll() as $feedSummary) {
            $feedSummaryData[$feedSummary->getExternal()->getId()] = $feedSummary;
        }
        $feedTitleData = [];
        foreach ($this->feedTitleRepository->findAll() as $feedTitle) {
            $feedTitleData[$feedTitle->getExternal()->getId()] = $feedTitle;
        }

        $result = [];
        foreach ($externalIdList as $externalId) {
            $result[] = new FullFeedEntry(
                $externalId,
                $feedTitleData[$externalId->getId()],
                $feedSummaryData[$externalId->getId()],
                $this->feedLinkRepository->findBy(['external' => $externalId->getId()])
            );
        }

        return $result;
    }
}
