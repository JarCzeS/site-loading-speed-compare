<?php
/**
 * Created by PhpStorm.
 * User: jaroslawjarczewski
 * Date: 01/11/2018
 * Time: 23:08
 */

namespace App\SiteLoader;


use App\SiteLoader\Reports\ReportsFactory;
use App\SiteLoader\ValueObjects\ResultsValueObject;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SiteLoaderCommand extends ContainerAwareCommand
{
    /**
     * @var OutputInterface
     */
    private $output;

    protected function configure()
    {
        $this->setName('compare-urls')->setDescription('Compare loading times of urls.')
            ->addArgument('url', InputArgument::REQUIRED, 'Base url to compare with')
            ->addArgument('competition', InputArgument::REQUIRED, 'Urls separated by comma to compare');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        /*
         * Load input sites and map to ValueObject
         */
        $this->outputInfo('Compare loading times of urls.');
        $results = $this->loadSites($input);
        $this->outputInfo("Loading end.\n");

        /*
         * Compare loading times
         */
        $this->outputInfo('Analyze loading times.');
        $analyzer = new Analyzer($results);
        $analyzer->compare();

        /*
         * Valid loading times
         */
        $this->outputInfo('Valid loading times.');
        $validator = new Validator();
        $validator->validLoadingTimes($results);
        if($validator->isSmsNotificationsSent()) {
            $this->outputInfo('SMS notification sent.');
        }
        if($validator->isEmailNotificationSent()) {
            $this->outputInfo('Email notification sent.');
        }

        /*
         * Generate reports
         */
        $this->generateReports($results);
    }

    private function outputInfo(string $msg) {
        return $this->output->writeln('<info>'.$msg.'</info>');
    }

    /**
     * @param $results
     */
    protected function generateReports($results): void
    {
        $reportFactory = new ReportsFactory();
        /**
         * ConsoleReport
         */
        $consoleReport = $reportFactory->consoleReport();
        $consoleReport->make($results);
        $this->outputInfo("\nConsole report generated.");
        /**
         * LogReport - saves in /var/log/log.txt
         */
        $logReport = $reportFactory->logReport();
        $logReport->make($results);
        $this->outputInfo("\nLog report generated.");
    }

    /**
     * @param InputInterface $input
     * @return ResultsValueObject
     */
    protected function loadSites(InputInterface $input): ResultsValueObject
    {
        $loader = new Loader($input->getArgument('url'), $input->getArgument('competition'));

        try {
            $results = $loader->getResults();
        } catch (Exceptions\InvalidUrlException $e) {
            $this->output->writeln('<error>' . $e->getMessage() . '</error>');
            exit;
        }

        return $results;
    }
}