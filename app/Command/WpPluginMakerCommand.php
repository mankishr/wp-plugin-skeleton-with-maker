<?php

namespace App\Command;

use App\Service\WPPluginMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WpPluginMakerCommand extends Command
{
    protected static $defaultName = 'app:make-wp-plugin';

    /**
     * @var WPPluginMaker
     */
    protected $wpPluginMaker;

    public function __construct()
    {
        $this->wpPluginMaker = new WPPluginMaker();
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileNames = $this->wpPluginMaker->createNewPluginFromWpPluginSkeleton();
        foreach ( $fileNames as  $val ){
            $output->writeln('Writing '.$val);
        }
        return Command::SUCCESS;
    }

}