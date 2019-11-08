<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedFoundWord
 *
 * @ORM\Table(name="feed_found_word", indexes={@ORM\Index(name="word_id", columns={"word_id"}), @ORM\Index(name="external_id", columns={"external_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\FeedFoundWordRepository")
 */
class FeedFoundWord
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_marked_for_delete", type="boolean", nullable=false)
     */
    private $isMarkedForDelete;

    /**
     * @var ExternalId
     *
     * @ORM\ManyToOne(targetEntity="ExternalId")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="external_id", referencedColumnName="id")
     * })
     */
    private $external;

    /**
     * @var Word
     *
     * @ORM\ManyToOne(targetEntity="Word")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="word_id", referencedColumnName="id")
     * })
     */
    private $word;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isMarkedForDelete(): bool
    {
        return $this->isMarkedForDelete;
    }

    /**
     * @param bool $isMarkedForDelete
     */
    public function setIsMarkedForDelete(bool $isMarkedForDelete): void
    {
        $this->isMarkedForDelete = $isMarkedForDelete;
    }

    /**
     * @return ExternalId
     */
    public function getExternal(): ExternalId
    {
        return $this->external;
    }

    /**
     * @param ExternalId $external
     */
    public function setExternal(ExternalId $external): void
    {
        $this->external = $external;
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
    public function setWord(Word $word): void
    {
        $this->word = $word;
    }


}
