<?php declare(strict_types=1);


namespace App\Controller;


use App\Repository\WordsTotalOccurrenceRepository;
use App\Repository\WordSupportedPlaceRepository;
use App\Service\WordCounterService;
use App\Service\WordFilterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /** @var WordsTotalOccurrenceRepository */
    protected $wordsTotalOccurrenceRepository;
    /** @var WordCounterService */
    protected $fullFeedDataGetterService;
    /** @var WordFilterService */
    protected $wordFilterService;
    /** @var WordSupportedPlaceRepository */
    protected $supportedPlaceRepository;

    public function __construct(
        WordsTotalOccurrenceRepository $wordsTotalOccurrenceRepository,
        WordCounterService $fullFeedDataGetterService,
        WordFilterService $wordFilterService,
        WordSupportedPlaceRepository $supportedPlaceRepository
    ) {
        $this->wordsTotalOccurrenceRepository = $wordsTotalOccurrenceRepository;
        $this->fullFeedDataGetterService      = $fullFeedDataGetterService;
        $this->wordFilterService              = $wordFilterService;
        $this->supportedPlaceRepository       = $supportedPlaceRepository;
    }

    /**
     * @Route("/{rank}/{removingItems}/{supportedPlaceIds}/{totalWords}", name="index")
     * @param string $rank
     * @param int $removingItems
     * @param string $supportedPlaceIds
     * @param int $totalWords
     * @return Response
     */
    public function indexAction(
        string $rank = 'oec',
        int $removingItems = 50,
        string $supportedPlaceIds = '1,2',
        int $totalWords = 10
    ): Response {
        $supportedPlaceIds = explode(',', $supportedPlaceIds);
        $this->wordFilterService->setRemovalData($rank, $removingItems);
        $this->fullFeedDataGetterService->setWordFilterService($this->wordFilterService);

        $templateData = [
            'mostCommonWords'       => $this->fullFeedDataGetterService->getTopWordCountCollection(
                $supportedPlaceIds,
                $totalWords
            ),
            'feedDataList'          => [],
            'rank'                  => $rank,
            'allSupportedPlaces'    => $this->supportedPlaceRepository->findAll(),
            'chosenSupportedPlaces' => $supportedPlaceIds,
            'removingItems'         => $removingItems,
            'totalWords' => $totalWords,
//            'error'           => $error,
        ];

        return $this->render(
            'taskDisplay.html.twig',
            $templateData
        );
    }
}
