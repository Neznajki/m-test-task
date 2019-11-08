<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WordsTotalOccurrence
 *
 * @ORM\Table(name="words_total_occurrence", indexes={@ORM\Index(name="word_id", columns={"word_id"}), @ORM\Index(name="supported_place_id", columns={"supported_place_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\WordsTotalOccurrenceRepository")
 */
class WordsTotalOccurrence
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
     * @var int
     *
     * @ORM\Column(name="appeared_times", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $appearedTimes;

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
     * @var WordSupportedPlace
     *
     * @ORM\ManyToOne(targetEntity="WordSupportedPlace")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="supported_place_id", referencedColumnName="id")
     * })
     */
    private $supportedPlace;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppearedTimes(): ?int
    {
        return $this->appearedTimes;
    }

    public function setAppearedTimes(int $appearedTimes): self
    {
        $this->appearedTimes = $appearedTimes;

        return $this;
    }

    public function getWord(): ?Word
    {
        return $this->word;
    }

    public function setWord(?Word $word): self
    {
        $this->word = $word;

        return $this;
    }

    public function getSupportedPlace(): ?WordSupportedPlace
    {
        return $this->supportedPlace;
    }

    public function setSupportedPlace(?WordSupportedPlace $supportedPlace): self
    {
        $this->supportedPlace = $supportedPlace;

        return $this;
    }


}
