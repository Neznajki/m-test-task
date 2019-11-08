<?php declare(strict_types=1);


namespace App\Downloader;


use App\ValueObject\FeedEntry;
use RuntimeException;
use SimpleXMLElement;

class FeedDownloader
{
    /** @var string */
    protected $feedLink;
    /** @var SimpleXMLElement */
    protected $externalDataStorage;

    /** @var SimpleXMLElement */
    protected $feedInfo;
    /** @var FeedEntry[] */
    protected $feedEntryCollection = [];

    /**
     * FeedDownloader constructor.
     * @param string $feedLink
     */
    public function __construct(string $feedLink)
    {
        $this->feedLink = $feedLink;
    }

    /**
     * @return SimpleXMLElement
     */
    public function getFeedInfo(): SimpleXMLElement
    {
        $this->downloadExternalData();

        return $this->feedInfo;
    }

    /**
     * don't use this in case
     * @return SimpleXMLElement[]
     */
    public function getFeedEntries(): array
    {
        $this->downloadExternalData();

        return $this->feedEntryCollection;
    }

    /**
     *
     */
    public function downloadExternalData(): void
    {
        if ($this->externalDataStorage === null) {
            $this->externalDataStorage = simplexml_load_file($this->feedLink);

            $this->gatherInfo();
        }
    }

    /**
     *
     */
    protected function gatherInfo(): void
    {
        if (empty($this->externalDataStorage->entry)) {
            throw new RuntimeException('feed have no entries');
        }

        foreach ($this->externalDataStorage->entry as $entry) {
            $this->feedEntryCollection[] = new FeedEntry($entry);
        }
        unset($this->feedInfo->entry);

        $this->feedInfo = $this->externalDataStorage;
    }
}
