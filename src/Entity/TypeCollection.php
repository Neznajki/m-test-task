<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeCollection
 *
 * @ORM\Table(name="type_collection", uniqueConstraints={@ORM\UniqueConstraint(name="u_type_name", columns={"type_name"})})
 * @ORM\Entity(repositoryClass="App\Repository\TypeCollectionRepository")
 */
class TypeCollection
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
     * @ORM\Column(name="type_name", type="string", length=128, nullable=false)
     */
    private $typeName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeName(): ?string
    {
        return $this->typeName;
    }

    public function setTypeName(string $typeName): self
    {
        $this->typeName = $typeName;

        return $this;
    }


}
