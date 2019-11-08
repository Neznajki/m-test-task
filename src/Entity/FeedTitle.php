<?php

namespace App\Entity;

use App\Contract\ContentIncludedEntity;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * FeedTitle
 *
 * @ORM\Table(name="feed_title", uniqueConstraints={@ORM\UniqueConstraint(name="u_external_id", columns={"external_id"})}, indexes={@ORM\Index(name="type_id", columns={"type_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\FeedTitleRepository")
 */
class FeedTitle implements ContentIncludedEntity
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
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="imported", type="datetime", nullable=false)
     */
    private $imported;

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
     * @var TypeCollection
     *
     * @ORM\ManyToOne(targetEntity="TypeCollection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImported(): ?DateTimeInterface
    {
        return $this->imported;
    }

    public function setImported(DateTimeInterface $imported): self
    {
        $this->imported = $imported;

        return $this;
    }

    public function getExternal(): ExternalId
    {
        return $this->external;
    }

    public function setExternal(ExternalId $external): self
    {
        $this->external = $external;

        return $this;
    }

    public function getType(): ?TypeCollection
    {
        return $this->type;
    }

    public function setType(?TypeCollection $type): self
    {
        $this->type = $type;

        return $this;
    }


}
