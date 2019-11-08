<?php declare(strict_types=1);


namespace App\Service\Converter;


use App\Contract\ConverterInterface;
use App\Entity\ExternalId;
use App\Repository\ExternalIdRepository;
use App\ValueObject\AbstractFeed;
use App\ValueObject\FeedEntry;
use Doctrine\ORM\ORMException;

class FeedExternalIdConverterService implements ConverterInterface
{
    /** @var ExternalIdRepository */
    protected $externalIdRepository;
    /** @var FeedAuthorConverterService */
    protected $feedAuthorConverterService;

    /**
     * FeedExternalIdConverterService constructor.
     * @param ExternalIdRepository $externalIdRepository
     * @param FeedAuthorConverterService $feedAuthorConverterService
     */
    public function __construct(
        ExternalIdRepository $externalIdRepository,
        FeedAuthorConverterService $feedAuthorConverterService
    )
    {
        $this->externalIdRepository = $externalIdRepository;
        $this->feedAuthorConverterService = $feedAuthorConverterService;
    }

    /**
     * @param AbstractFeed|FeedEntry $abstractFeed
     * @return ExternalId
     * @throws ORMException
     */
    public function convert(AbstractFeed $abstractFeed): ExternalId
    {
        $author = $this->feedAuthorConverterService->convert($abstractFeed->getAuthor());

        return $this->externalIdRepository->getOrCreateEntityByData($abstractFeed, $author);
    }
}
