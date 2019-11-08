<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * FeedLink
 *
 * @ORM\Table(name="feed_link", uniqueConstraints={@ORM\UniqueConstraint(name="u_external_id_href", columns={"external_id", "href"})}, indexes={@ORM\Index(name="type_id", columns={"type_id"}), @ORM\Index(name="rel_id", columns={"rel_id"}), @ORM\Index(name="IDX_B63B72A69F75D7B0", columns={"external_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\FeedLinkRepository")
 */
class FeedLink
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
     * @ORM\Column(name="href", type="string", length=200, nullable=false)
     */
    private $href;

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
     * @var RelCollection
     *
     * @ORM\ManyToOne(targetEntity="RelCollection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rel_id", referencedColumnName="id")
     * })
     */
    private $rel;

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

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(string $href): self
    {
        $this->href = $href;

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

    public function getExternal(): ?ExternalId
    {
        return $this->external;
    }

    public function setExternal(?ExternalId $external): self
    {
        $this->external = $external;

        return $this;
    }

    public function getRel(): ?RelCollection
    {
        return $this->rel;
    }

    public function setRel(?RelCollection $rel): self
    {
        $this->rel = $rel;

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
