<?php declare(strict_types=1);


namespace App\Service\Converter;


use App\Contract\ConverterInterface;
use App\Entity\ExternalId;
use App\Entity\FeedTitle;
use App\Repository\FeedTitleRepository;
use App\Repository\TypeCollectionRepository;
use App\ValueObject\AbstractFeed;
use Doctrine\ORM\ORMException;
use RuntimeException;

class FeedTitleConverterService implements ConverterInterface
{
    /** @var FeedTitleRepository */
    protected $feedTitleRepository;
    /** @var TypeCollectionRepository */
    protected $typeCollectionRepository;

    public function __construct(
        FeedTitleRepository $feedTitleRepository,
        TypeCollectionRepository $typeCollectionRepository
    )
    {
        $this->feedTitleRepository = $feedTitleRepository;
        $this->typeCollectionRepository = $typeCollectionRepository;
    }

    /**
     * @param \App\ValueObject\FeedTitle|AbstractFeed $abstractFeed
     * @param ExternalId|null $externalId
     * @return FeedTitle
     * @throws ORMException
     */
    public function convert(AbstractFeed $abstractFeed, ExternalId $externalId = null): FeedTitle
    {
        if ($externalId === null) {
            throw new RuntimeException('externalId required to create feed title');
        }

        $type = $this->typeCollectionRepository->getOrCreateEntityByData($abstractFeed);

        return $this->feedTitleRepository->getOrCreateEntityByData($abstractFeed, $externalId, $type);
    }
}
