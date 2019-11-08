<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Words
 *
 * @ORM\Table(name="word", uniqueConstraints={@ORM\UniqueConstraint(name="u_word", columns={"word"})})
 * @ORM\Entity(repositoryClass="App\Repository\WordRepository")
 */
class Word
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
     * @ORM\Column(name="word", type="string", length=32, nullable=false)
     */
    private $word;

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

}
