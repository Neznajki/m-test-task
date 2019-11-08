<?php declare(strict_types=1);


namespace App\Service;


use App\DataObject\MostCommonWordEntry;
use App\Entity\Word;
use App\Repository\MostCommonWordsRepository;
use App\Repository\WordRepository;
use InvalidArgumentException;

class WordFilterService
{
    /** @var MostCommonWordsRepository */
    protected $mostCommonWordsRepository;
    /** @var Word[] */
    protected $forbiddenWordsCollection = [];
    /** @var WordRepository */
    protected $wordRepository;
    /** @var bool */
    protected $exclusionsSet = false;

    public function __construct(
        MostCommonWordsRepository $mostCommonWordsRepository,
        WordRepository $wordRepository
    ) {
        $this->mostCommonWordsRepository = $mostCommonWordsRepository;
        $this->wordRepository            = $wordRepository;
    }

    /**
     * @param string $topType
     * @param int $elementCount
     */
    public function setRemovalData(string $topType, int $elementCount)
    {
        switch ($topType) {
            case 'oec':
                $fieldName = 'oecRank';
                break;
            case 'coca':
                $fieldName = 'cocaRank';
                break;
            default:
                throw new InvalidArgumentException("invalid type provided {$topType}");
        }

        $mostCommonWords                = $this->mostCommonWordsRepository->findBy([], [$fieldName => 'ASC'], $elementCount);
        $commonWordStrings = [];
        foreach ($mostCommonWords as $mostCommonWordEntity) {
            $commonWordStrings[] = $mostCommonWordEntity->getWord();
        }
        $this->forbiddenWordsCollection = $this->wordRepository->findBy(
            ['word' => $commonWordStrings]
        );

        $this->exclusionsSet = true;
    }

    /**
     * @param MostCommonWordEntry[] $allWords
     * @return MostCommonWordEntry[]
     */
    public function removeForbiddenRecords(array $allWords): array
    {
        $result = $allWords;
        foreach ($this->forbiddenWordsCollection as $forbiddenWord) {
            unset($result[$forbiddenWord->getId()]);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isExclusionsSet(): bool
    {
        return $this->exclusionsSet;
    }
}
