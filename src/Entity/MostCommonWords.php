<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MostCommonWords
 *
 * @ORM\Table(name="most_common_words", uniqueConstraints={@ORM\UniqueConstraint(name="u_word", columns={"word"})})
 * @ORM\Entity(repositoryClass="App\Repository\MostCommonWordsRepository")
 */
class MostCommonWords
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
     * @var string
     *
     * @ORM\Column(name="word", type="string", length=16, nullable=false)
     */
    private $word;

    /**
     * @var bool
     *
     * @ORM\Column(name="oec_rank", type="boolean", nullable=false)
     */
    private $oecRank;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="coca_rank", type="boolean", nullable=true)
     */
    private $cocaRank;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): self
    {
        $this->word = $word;

        return $this;
    }

    public function getOecRank(): ?bool
    {
        return $this->oecRank;
    }

    public function setOecRank(bool $oecRank): self
    {
        $this->oecRank = $oecRank;

        return $this;
    }

    public function getCocaRank(): ?bool
    {
        return $this->cocaRank;
    }

    public function setCocaRank(?bool $cocaRank): self
    {
        $this->cocaRank = $cocaRank;

        return $this;
    }


}
