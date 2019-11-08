<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * FeedAuthor
 *
 * @ORM\Table(name="feed_author")
 * @ORM\Entity(repositoryClass="App\Repository\FeedAuthorRepository")
 */
class FeedAuthor
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
     * @ORM\Column(name="full_name", type="string", length=128, nullable=false)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="homepage_uri", type="string", length=128, nullable=false)
     */
    private $homepageUri;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_address", type="string", length=128, nullable=true)
     */
    private $emailAddress;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getHomepageUri(): ?string
    {
        return $this->homepageUri;
    }

    public function setHomepageUri(string $homepageUri): self
    {
        $this->homepageUri = $homepageUri;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getCreated(): ?DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }


}
