<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedSummary
 *
 * @ORM\Table(name="feed_summary", uniqueConstraints={@ORM\UniqueConstraint(name="u_external_id", columns={"external_id"})}, indexes={@ORM\Index(name="type_id", columns={"type_id"}), @ORM\Index(name="xml_base_id", columns={"xml_base_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\FeedSummaryRepository")
 */
class FeedSummary
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
     * @var TypeCollection
     *
     * @ORM\ManyToOne(targetEntity="TypeCollection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @var ExternalId
     *
     * @ORM\ManyToOne(targetEntity="ExternalId")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="external_id", referencedColumnName="id")
     * })
     */
    private $external;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getExternal(): ?ExternalId
    {
        return $this->external;
    }

    public function setExternal(?ExternalId $external): self
    {
        $this->external = $external;

        return $this;
    }


}
