<?php declare(strict_types=1);


namespace App\DataObject;


use App\Entity\Word;
use App\Entity\WordsTotalOccurrence;
use InvalidArgumentException;
use RuntimeException;

class MostCommonWordEntry
{
    /** @var int */
    protected $totals = 0;
    /** @var Word */
    private $word;

    /**
     * MostCommonWordEntry constructor.
     * @param Word $wordId
     */
    public function __construct(Word $wordId)
    {
        $this->word = $wordId;
    }

    /**
     * @return Word
     */
    public function getWord(): Word
    {
        return $this->word;
    }

    /**
     * @param Word $word
     */
    public function setWord(Word $word)
    {
        if ($this->getWord()->getId() !== $word->getId()) {
            throw new RuntimeException('you can\'t change word');
        }

        $this->word = $word;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->totals;
    }

    /**
     * @param WordsTotalOccurrence $wordsTotalOccurrence
     */
    public function merge(WordsTotalOccurrence $wordsTotalOccurrence)
    {
        if ($this->getWord()->getId() !== $wordsTotalOccurrence->getWord()->getId()) {
            throw new InvalidArgumentException('word is not the same');
        }

        $this->totals += $wordsTotalOccurrence->getAppearedTimes();
    }
}
