<?php declare(strict_types=1);


namespace App\Service;


use App\Entity\FeedFoundWord;
use App\Entity\WordSupportedPlace;
use App\Repository\WordsTotalOccurrenceRepository;
use App\Repository\WordSupportedPlaceRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class WordCollectingService
{

    /** @var WordGatherService */
    protected $wordGatherService;
    /** @var WordSupportedPlaceRepository */
    protected $wordSupportedPlaceRepository;
    /** @var WordsTotalOccurrenceRepository */
    protected $wordsTotalOccurrenceRepository;
    /** @var WordSupportedPlace[] */
    protected $supportedPLaces = [];

    public function __construct(
        WordGatherService $wordGatherService,
        WordSupportedPlaceRepository $wordSupportedPlaceRepository,
        WordsTotalOccurrenceRepository $wordsTotalOccurrenceRepository
    )
    {
        $this->wordGatherService = $wordGatherService;
        $this->wordSupportedPlaceRepository = $wordSupportedPlaceRepository;
        $this->wordsTotalOccurrenceRepository = $wordsTotalOccurrenceRepository;
    }

    /**
     * @return FeedFoundWord[]
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function collectWords(): array
    {
        $result = [];
        foreach ($this->getAllSupportedPlaces() as $wordSupportedPlace) {
            $result = array_merge($result, $this->wordGatherService->gatherWords($wordSupportedPlace));
        }

        return $result;
    }

    /**
     * @param FeedFoundWord[] $feedWordsList
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveWords(array $feedWordsList)
    {
        $this->wordGatherService->saveChanges($feedWordsList);
        $this->wordGatherService->importDone();
    }

    /**
     * @throws DBALException
     */
    public function markTotalAppearance(): void
    {
        foreach ($this->getAllSupportedPlaces() as $wordSupportedPlace) {
            $this->wordsTotalOccurrenceRepository->groupInformationExistingData($wordSupportedPlace);
        }
    }

    /**
     * @return WordSupportedPlace[]
     */
    protected function getAllSupportedPlaces(): array
    {
        if ($this->supportedPLaces === []) {
            $this->supportedPLaces = $this->wordSupportedPlaceRepository->findAll();
        }

        return $this->supportedPLaces;
    }
}
