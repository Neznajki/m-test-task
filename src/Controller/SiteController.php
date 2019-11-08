<?php declare(strict_types=1);


namespace App\Controller;


use App\Repository\WordsTotalOccurrenceRepository;
use App\Repository\WordSupportedPlaceRepository;
use App\Service\FeedFullDataGetterService;
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
    protected $wordCounterService;
    /** @var WordFilterService */
    protected $wordFilterService;
    /** @var WordSupportedPlaceRepository */
    protected $supportedPlaceRepository;
    /** @var FeedFullDataGetterService */
    protected $feedFullDataGetterService;

    public function __construct(
        WordsTotalOccurrenceRepository $wordsTotalOccurrenceRepository,
        WordCounterService $wordCounterService,
        WordFilterService $wordFilterService,
        WordSupportedPlaceRepository $supportedPlaceRepository,
        FeedFullDataGetterService $feedFullDataGetterService
    ) {
        $this->wordsTotalOccurrenceRepository = $wordsTotalOccurrenceRepository;
        $this->wordCounterService             = $wordCounterService;
        $this->wordFilterService              = $wordFilterService;
        $this->supportedPlaceRepository       = $supportedPlaceRepository;
        $this->feedFullDataGetterService      = $feedFullDataGetterService;
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
        $this->wordCounterService->setWordFilterService($this->wordFilterService);

        $templateData = [
            'mostCommonWords'       => $this->wordCounterService->getTopWordCountCollection(
                $supportedPlaceIds,
                $totalWords
            ),
            'feedDataList'          => $this->feedFullDataGetterService->getFullFeedData(),
            'rank'                  => $rank,
            'allSupportedPlaces'    => $this->supportedPlaceRepository->findAll(),
            'chosenSupportedPlaces' => $supportedPlaceIds,
            'removingItems'         => $removingItems,
            'totalWords'            => $totalWords,
//            'error'           => $error,
        ];

        return $this->render(
            'taskDisplay.html.twig',
            $templateData
        );
    }
}
