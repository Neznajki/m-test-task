<?php declare(strict_types=1);


namespace App\Service;


use App\Contract\ContentIncludedEntity;
use App\Repository\WordRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ContentParserService
{
    /** @var WordRepository */
    protected $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    /**
     * @param ContentIncludedEntity $entity
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getWordsList(ContentIncludedEntity $entity): array
    {
        $stripedContent = strip_tags($entity->getContent());
        $explodedWordData = explode(' ', preg_replace('/\s+/', ' ', $stripedContent));

        $uniqueWordList = $this->getUniqueWords($explodedWordData);

        $existingEntityList = $this->wordRepository->getExistingWords($uniqueWordList);
        $uniqueEntityList = [];

        foreach ($existingEntityList as $wordEntity) {
            $uniqueEntityList[$wordEntity->getWord()] = $wordEntity;
            unset($uniqueWordList[$wordEntity->getWord()]);
        }

        foreach ($uniqueWordList as $word) {
            $uniqueEntityList[$word] = $this->wordRepository->createEntityByData($word);
        }
        $this->wordRepository->flushChanges($uniqueEntityList);

        $result =[];

        foreach ($explodedWordData as $word) {
            $cleanWord = $this->removeNotWordSymbols($word);
            if (empty($cleanWord)) {
                continue;
            }

            $result[] = $uniqueEntityList[$this->getWordUniqueValue($cleanWord)];
        }

        return $result;
    }

    /**
     * @param array $explodedWordData
     * @return array
     */
    protected function getUniqueWords(array $explodedWordData): array
    {
        $uniqueWordList = [];

        foreach ($explodedWordData as $wordString) {
            $lowerWord                  = $this->removeNotWordSymbols($wordString);
            if (empty($lowerWord)) {
                continue;
            }

            $uniqueWordList[$lowerWord] = $lowerWord;
        }

        return $uniqueWordList;
    }

    /**
     * @param $wordString
     * @return string
     */
    protected function getWordUniqueValue($wordString): string
    {
        return strtolower($wordString);
    }

    /**
     * @param $wordString
     * @return string|string[]|null
     */
    protected function removeNotWordSymbols($wordString)
    {
        return preg_replace('/[^a-z]/', '', $this->getWordUniqueValue($wordString));
    }
}
