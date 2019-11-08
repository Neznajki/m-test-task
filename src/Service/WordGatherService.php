<?php declare(strict_types=1);


namespace App\Service;


use App\Contract\ContentGatheringSupport;
use App\Contract\ContentIncludedEntity;
use App\Entity\Word;
use App\Entity\WordSupportedPlace;
use App\Repository\FeedFoundWordRepository;
use App\Repository\FeedSummaryRepository;
use App\Repository\FeedTitleRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use RuntimeException;

class WordGatherService
{
    /** @var FeedTitleRepository */
    protected $feedTitleRepository;
    /** @var FeedSummaryRepository */
    protected $feedSummaryRepository;
    /** @var ContentParserService */
    protected $contentParserService;
    /** @var FeedFoundWordRepository */
    protected $feedFoundWordRepository;
    /** @var bool */
    protected $firstRepository = true;

    public function __construct(
        FeedTitleRepository $feedTitleRepository,
        FeedSummaryRepository $feedSummaryRepository,
        ContentParserService $contentParserService,
        FeedFoundWordRepository $feedFoundWordRepository
    ) {
        $this->feedTitleRepository   = $feedTitleRepository;
        $this->feedSummaryRepository = $feedSummaryRepository;
        $this->contentParserService  = $contentParserService;
        $this->feedFoundWordRepository = $feedFoundWordRepository;
    }

    /**
     * @param WordSupportedPlace $wordSupportedPlace
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function gatherWords(WordSupportedPlace $wordSupportedPlace): array
    {
        return $this->getWordsFromRepository(
            $this->getResponsibleRepository($wordSupportedPlace)
        );
    }

    /**
     * @param array $feedWordList
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveChanges(array $feedWordList)
    {
        $this->feedFoundWordRepository->flushChanges($feedWordList);
    }

    /**
     *
     */
    public function importDone()
    {
        $this->feedFoundWordRepository->importDone();
    }

    /**
     * @param ContentGatheringSupport $contactGatheringRepository
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function getWordsFromRepository(ContentGatheringSupport $contactGatheringRepository): array
    {
        $contentIncludedEntities = $contactGatheringRepository->getEntityWithContentList();

        $result = [];
        foreach ($contentIncludedEntities as $contentIncludedEntity) {
            if ($this->firstRepository) {
                $this->feedFoundWordRepository->importBegan($contentIncludedEntity);
            }
            $newEntityList = $this->getFoundWordEntityList(
                $this->contentParserService->getWordsList($contentIncludedEntity),
                $contentIncludedEntity
            );
            $result    = array_merge($result, $newEntityList);
        }

        $this->firstRepository = false;
        return $result;
    }

    /**
     * @param Word[] $wordsEntityList
     * @param ContentIncludedEntity $contentIncludedEntity
     * @return array
     * @throws ORMException
     */
    protected function getFoundWordEntityList(array $wordsEntityList, ContentIncludedEntity $contentIncludedEntity): array
    {
        $result = [];
        foreach ($wordsEntityList as $item) {
            $feedFoundWord = $this->feedFoundWordRepository->createNewRelationEntity($item, $contentIncludedEntity);
            $result[]      = $feedFoundWord;
        }

        return $result;
    }

    /**
     * @param WordSupportedPlace $wordSupportedPlace
     * @return ContentGatheringSupport
     */
    protected function getResponsibleRepository(WordSupportedPlace $wordSupportedPlace): ContentGatheringSupport
    {
        switch ($wordSupportedPlace->getSourceName()) {
            case 'title':
                $repository = $this->feedTitleRepository;
                break;
            case 'summary':
                $repository = $this->feedSummaryRepository;
                break;
            default:
                throw new RuntimeException(sprintf('unsupported place %s', $wordSupportedPlace->getSourceName()));
        }

        return $repository;
    }
}
