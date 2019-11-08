<?php declare(strict_types=1);


namespace App\Command;


use App\Service\FeedParserService;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class ImportDataCommand extends Command
{
// the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:import-data';

    /** @var FeedParserService */
    protected $handlerService;
    /** @var Stopwatch */
    protected $stopwatch;

    /**
     * @param FeedParserService $handlerService
     */
    public function setHandlerService(FeedParserService $handlerService): void
    {
        $this->handlerService = $handlerService;
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('imports data from external feed')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command will fill database and update data with provided feed')
            ->addArgument('feedUrl', InputArgument::OPTIONAL, 'The username of the user.', 'https://www.theregister.co.uk/software/headlines.atom');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws ORMException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->handlerService->setOutput($output);

        $this->stopwatch = new Stopwatch();
        $timerEvent = $this->stopwatch->start('feedDownload');
        $downloader = $this->handlerService->parseFeed($input->getArgument('feedUrl'));
        $output->writeln(sprintf('data downloaded in %s', $timerEvent->stop()->getDuration()));

        $timerEvent = $this->stopwatch->start('feedConvert');
        $this->handlerService->convertFeedEntryToEntity($downloader->getFeedEntries());
        $output->writeln(sprintf('data converted in %s', $timerEvent->stop()->getDuration()));

        $timerEvent = $this->stopwatch->start('feedConvert');
        $this->handlerService->saveFeedData();
        $output->writeln(sprintf('data saved in %s', $timerEvent->stop()->getDuration()));
    }
}
