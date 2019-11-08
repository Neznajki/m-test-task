<?php declare(strict_types=1);


namespace App\Service\Converter;


use App\Entity\ExternalId;
use App\Entity\FeedSummary;
use App\Repository\FeedSummaryRepository;
use App\Repository\TypeCollectionRepository;
use App\ValueObject\AbstractFeed;
use Doctrine\ORM\ORMException;
use RuntimeException;

class FeedSummaryConverterService
{
    /** @var FeedSummaryRepository */
    protected $feedSummaryRepository;
    /** @var TypeCollectionRepository */
    protected $typeCollectionRepository;

    public function __construct(
        FeedSummaryRepository $feedSummaryRepository,
        TypeCollectionRepository $typeCollectionRepository
    ) {
        $this->feedSummaryRepository    = $feedSummaryRepository;
        $this->typeCollectionRepository = $typeCollectionRepository;
    }

    /**
     * @param \App\ValueObject\FeedSummary|AbstractFeed $abstractFeed
     * @param ExternalId|null $externalId
     * @return FeedSummary
     * @throws ORMException
     */
    public function convert(AbstractFeed $abstractFeed, ExternalId $externalId = null): FeedSummary
    {
        if ($externalId === null) {
            throw new RuntimeException('externalId required to create feed title');
        }
        $type = $this->typeCollectionRepository->getOrCreateEntityByData($abstractFeed);

        return $this->feedSummaryRepository->getOrCreateEntityByData($abstractFeed, $externalId, $type);
    }
}
