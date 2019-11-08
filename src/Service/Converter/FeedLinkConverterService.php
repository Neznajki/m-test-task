<?php declare(strict_types=1);


namespace App\Service\Converter;


use App\Contract\ConverterInterface;
use App\Entity\ExternalId;
use App\Entity\FeedLink;
use App\Repository\FeedLinkRepository;
use App\Repository\RelCollectionRepository;
use App\Repository\TypeCollectionRepository;
use App\ValueObject\AbstractFeed;
use Doctrine\ORM\ORMException;
use RuntimeException;

class FeedLinkConverterService implements ConverterInterface
{

    /** @var FeedLinkRepository */
    protected $feedLinkRepository;
    /** @var RelCollectionRepository */
    protected $relCollectionRepository;
    /** @var TypeCollectionRepository */
    protected $typeCollectionRepository;

    public function __construct(
        FeedLinkRepository $feedLinkRepository,
        RelCollectionRepository $relCollectionRepository,
        TypeCollectionRepository $typeCollectionRepository
    ) {
        $this->feedLinkRepository       = $feedLinkRepository;
        $this->relCollectionRepository  = $relCollectionRepository;
        $this->typeCollectionRepository = $typeCollectionRepository;
    }

    /**
     * @param \App\ValueObject\FeedLink|AbstractFeed $abstractFeed
     * @param ExternalId|null $externalId
     * @return FeedLink
     * @throws ORMException
     */
    public function convert(AbstractFeed $abstractFeed, ExternalId $externalId = null): FeedLink
    {
        if ($externalId === null) {
            throw new RuntimeException('externalId required to create feed title');
        }

        $type = $this->typeCollectionRepository->getOrCreateEntityByData($abstractFeed);
        $rel = $this->relCollectionRepository->getOrCreateEntityByData($abstractFeed);

        return $this->feedLinkRepository->getOrCreateEntityByData($abstractFeed, $externalId, $type, $rel);

    }
}
