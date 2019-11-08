<?php declare(strict_types=1);


namespace App\Service\Converter;


use App\Contract\ConverterInterface;
use App\Entity\FeedAuthor;
use App\Repository\FeedAuthorRepository;
use App\ValueObject\AbstractFeed;
use Doctrine\ORM\ORMException;

class FeedAuthorConverterService implements ConverterInterface
{
    /** @var FeedAuthorRepository */
    protected $authorRepository;

    public function __construct(FeedAuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @param AbstractFeed|\App\ValueObject\FeedAuthor $abstractFeed
     * @return FeedAuthor
     * @throws ORMException
     */
    public function convert(AbstractFeed $abstractFeed): FeedAuthor
    {
        return $this->authorRepository->getOrCreateEntityByData($abstractFeed);
    }
}
