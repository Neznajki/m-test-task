<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WordSupportedPlaces
 *
 * @ORM\Table(name="word_supported_place", uniqueConstraints={@ORM\UniqueConstraint(name="u_source_name", columns={"source_name"})})
 * @ORM\Entity(repositoryClass="App\Repository\WordSupportedPlaceRepository")
 */
class WordSupportedPlace
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
     * @ORM\Column(name="source_name", type="string", length=32, nullable=false)
     */
    private $sourceName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceName(): ?string
    {
        return $this->sourceName;
    }

    public function setSourceName(string $sourceName): self
    {
        $this->sourceName = $sourceName;

        return $this;
    }


}
