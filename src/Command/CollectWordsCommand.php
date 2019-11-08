<?php declare(strict_types=1);


namespace App\Command;


use App\Service\WordCollectingService;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * could be hardly optimized no time for that
 * Class CollectWordsCommand
 * @package App\Command
 */
class CollectWordsCommand extends Command
{
// the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:words-gather';

    /** @var WordCollectingService */
    protected $handlerService;
    /** @var Stopwatch */
    protected $stopwatch;

    /**
     * @param WordCollectingService $handlerService
     */
    public function setHandlerService(WordCollectingService $handlerService): void
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
            ->setHelp('This command will fill database and update data with provided feed');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws DBALException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->stopwatch = new Stopwatch();
        $timerEvent = $this->stopwatch->start('wordsCollect');
        $collectWords = $this->handlerService->collectWords();
        $output->writeln(sprintf('words collected in %s', $timerEvent->stop()->getDuration()));

        $timerEvent = $this->stopwatch->start('wordsSave');
        $this->handlerService->saveWords($collectWords);
        $output->writeln(sprintf('data saved in %s', $timerEvent->stop()->getDuration()));

        $timerEvent = $this->stopwatch->start('wordsSum');
        $this->handlerService->markTotalAppearance();
        $output->writeln(sprintf('data summarized in %s', $timerEvent->stop()->getDuration()));
    }
}
