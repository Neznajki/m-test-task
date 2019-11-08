<?php declare(strict_types=1);


namespace App\Service;


use App\DataObject\FullFeedEntry;
use App\Downloader\FeedDownloader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use SimpleXMLElement;
use Symfony\Component\Console\Output\OutputInterface;

class FeedParserService
{
    /** @var OutputInterface */
    protected $output;
    /** @var FeedDataConverter */
    protected $feedDataConverter;
    /** @var FeedDataSaverService */
    protected $feedDataSaverService;
    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(
        FeedDataConverter $feedDataConverter,
        FeedDataSaverService $feedDataSaverService,
        EntityManagerInterface $entityManager
    ) {
        $this->feedDataConverter    = $feedDataConverter;
        $this->feedDataSaverService = $feedDataSaverService;
        $this->entityManager = $entityManager;
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
        return $this->feedDataConverter->convertEntryObjectToEntity($feedData);
    }

    /**
     *
     */
    public function saveFeedData()
    {
        $this->entityManager->flush();
    }


    /**
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }
}
