<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * ExternalId
 *
 * @ORM\Table(name="external_id", uniqueConstraints={@ORM\UniqueConstraint(name="u_external_id", columns={"external_id"})}, indexes={@ORM\Index(name="author_id", columns={"author_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ExternalIdRepository")
 */
class ExternalId
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
     * @ORM\Column(name="external_id", type="string", length=128, nullable=false)
     */
    private $externalId;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="last_update_time", type="datetime", nullable=false)
     */
    private $lastUpdateTime;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="last_import_time", type="datetime", nullable=false)
     */
    private $lastImportTime;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="imported", type="datetime", nullable=false)
     */
    private $imported;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_removed", type="boolean", nullable=false)
     */
    private $isRemoved;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_handling", type="boolean", nullable=false)
     */
    private $isHandling;

    /**
     * @var FeedAuthor
     *
     * @ORM\ManyToOne(targetEntity="FeedAuthor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     * })
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getLastUpdateTime(): ?DateTimeInterface
    {
        return $this->lastUpdateTime;
    }

    public function setLastUpdateTime(DateTimeInterface $lastUpdateTime): self
    {
        $this->lastUpdateTime = $lastUpdateTime;

        return $this;
    }

    public function getLastImportTime(): ?DateTimeInterface
    {
        return $this->lastImportTime;
    }

    public function setLastImportTime(DateTimeInterface $lastImportTime): self
    {
        $this->lastImportTime = $lastImportTime;

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

    public function getIsRemoved(): ?bool
    {
        return $this->isRemoved;
    }

    public function setIsRemoved(bool $isRemoved): self
    {
        $this->isRemoved = $isRemoved;

        return $this;
    }

    public function getIsHandling(): ?bool
    {
        return $this->isHandling;
    }

    public function setIsHandling(bool $isHandling): self
    {
        $this->isHandling = $isHandling;

        return $this;
    }

    public function getAuthor(): ?FeedAuthor
    {
        return $this->author;
    }

    public function setAuthor(?FeedAuthor $author): self
    {
        $this->author = $author;

        return $this;
    }


}
