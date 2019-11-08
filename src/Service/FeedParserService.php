<?php declare(strict_types=1);


namespace App\Service;


use App\DataObject\FullFeedEntry;
use App\Downloader\FeedDownloader;
use App\Repository\ExternalIdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use SimpleXMLElement;

class FeedParserService
{
    /** @var FeedDataConverter */
    protected $feedDataConverter;
    /** @var FeedDataSaverService */
    protected $feedDataSaverService;
    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var ExternalIdRepository */
    protected $externalIdRepository;

    public function __construct(
        FeedDataConverter $feedDataConverter,
        FeedDataSaverService $feedDataSaverService,
        EntityManagerInterface $entityManager,
        ExternalIdRepository $externalIdRepository
    ) {
        $this->feedDataConverter    = $feedDataConverter;
        $this->feedDataSaverService = $feedDataSaverService;
        $this->entityManager = $entityManager;
        $this->externalIdRepository = $externalIdRepository;
    }

    /**
     * @param string $feedLink
     * @return FeedDownloader
     */
    public function parseFeed(string $feedLink): FeedDownloader
    {
        $feedDownloader = new FeedDownloader($feedLink);
        $feedDownloader->downloadExternalData();

        return $feedDownloader;
    }

    /**
     * @param SimpleXMLElement[] $feedData
     * @return FullFeedEntry[]
     * @throws ORMException
     */
    public function convertFeedEntryToEntity(array $feedData): array
    {
        $this->externalIdRepository->importBegan();
        $fullFeedEntries = $this->feedDataConverter->convertEntryObjectToEntity($feedData);

        return $fullFeedEntries;
    }

    /**
     *
     */
    public function saveFeedData()
    {
        $this->entityManager->flush();
        $this->externalIdRepository->importDone();
    }
}
