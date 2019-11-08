<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RelCollection
 *
 * @ORM\Table(name="rel_collection", uniqueConstraints={@ORM\UniqueConstraint(name="u_rel_name", columns={"rel_name"})})
 * @ORM\Entity(repositoryClass="App\Repository\RelCollectionRepository")
 */
class RelCollection
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
     * @ORM\Column(name="rel_name", type="string", length=128, nullable=false)
     */
    private $relName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelName(): ?string
    {
        return $this->relName;
    }

    public function setRelName(string $relName): self
    {
        $this->relName = $relName;

        return $this;
    }


}
