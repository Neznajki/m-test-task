<?php declare(strict_types=1);


namespace App\Service;


use App\DataObject\MostCommonWordEntry;
use App\Entity\WordsTotalOccurrence;
use App\Repository\WordRepository;
use App\Repository\WordsTotalOccurrenceRepository;
use RuntimeException;

class WordCounterService
{
    /** @var MostCommonWordEntry[] */
    protected $wordCollection = [];
    /** @var WordsTotalOccurrenceRepository */
    protected $wordsTotalOccurrenceRepository;
    /** @var WordRepository */
    protected $wordRepository;
    /** @var WordFilterService */
    protected $wordFilterService;

    public function __construct(
        WordsTotalOccurrenceRepository $wordsTotalOccurrenceRepository,
        WordRepository $wordRepository
    ) {
        $this->wordsTotalOccurrenceRepository = $wordsTotalOccurrenceRepository;
        $this->wordRepository                 = $wordRepository;
    }

    /**
     * @return WordFilterService
     */
    public function getWordFilterService(): WordFilterService
    {
        if (empty($this->wordFilterService)) {
            throw new RuntimeException('wordFilterService should be set');
        }

        if (! $this->wordFilterService->isExclusionsSet()) {
            throw new RuntimeException('please set exclusion before wordFilterService usage');
        }

        return $this->wordFilterService;
    }

    /**
     * @param WordFilterService $wordFilterService
     */
    public function setWordFilterService(WordFilterService $wordFilterService): void
    {
        $this->wordFilterService = $wordFilterService;
    }

    /**
     * @param array $supportedPlaceIds
     * @param int $entryCount
     * @return MostCommonWordEntry[]
     */
    public function getTopWordCountCollection(array $supportedPlaceIds, int $entryCount): array
    {
        if (empty($supportedPlaceIds)) {
            return [];
        }

        $this->fillWordCountCollection($supportedPlaceIds);
        $topEntries = $this->getTopEntries($entryCount);
        $this->setWordStrings($topEntries);

        return $topEntries;
    }

    /**
     * @param array $supportedPlaceIds
     */
    protected function fillWordCountCollection(array $supportedPlaceIds)
    {
        foreach ($supportedPlaceIds as $placeId) {
            $foundEntities = $this->wordsTotalOccurrenceRepository->findBy(['supportedPlace' => $placeId]);

            foreach ($foundEntities as $wordsTotalOccurrence) {
                $this->getMostCommonWordEntry($wordsTotalOccurrence)->merge($wordsTotalOccurrence);
            }
        }

        $this->wordCollection = $this->getWordFilterService()->removeForbiddenRecords($this->wordCollection);

    }

    /**
     * @param WordsTotalOccurrence $wordEntity
     * @return MostCommonWordEntry
     */
    protected function getMostCommonWordEntry(WordsTotalOccurrence $wordEntity): MostCommonWordEntry
    {
        $word = $wordEntity->getWord();
        $wordId  = $word->getId();
        if (empty($this->wordCollection[$wordId])) {
            $this->wordCollection[$wordId] = new MostCommonWordEntry($word);
        }

        return $this->wordCollection[$wordId];
    }

    /**
     * @param int $entryCount
     * @return array
     */
    protected function getTopEntries(int $entryCount): array
    {
        uasort(
            $this->wordCollection,
            function (MostCommonWordEntry $a, MostCommonWordEntry $b) {
                return $b->getTotal() - $a->getTotal();
            }
        );

        return array_slice($this->wordCollection, 0, $entryCount);
    }

    /**
     * @param MostCommonWordEntry[] $wordCollection
     */
    protected function setWordStrings(array $wordCollection): void
    {
        $wordsRequired = [];

        foreach ($wordCollection as $mostCommonWordsEntry) {
            $word                          = $mostCommonWordsEntry->getWord();
            $wordsRequired[$word->getId()] = $mostCommonWordsEntry;
        }

        $wordsData = $this->wordRepository->findBy(['id' => array_keys($wordsRequired)]);

        foreach ($wordsData as $wordEntity) {
            $wordsRequired[$wordEntity->getId()]->setWord($wordEntity);
        }
    }
}
