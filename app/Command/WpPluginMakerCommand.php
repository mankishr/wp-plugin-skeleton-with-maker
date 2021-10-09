<?php

namespace App\Command;

use App\Service\WPPluginMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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

    protected function configure(): void
    {
        $this->addArgument('plugin_name', InputArgument::REQUIRED, 'Plugin name');
        $this->addArgument('author', InputArgument::REQUIRED, 'Author <email>');
        $this->addArgument('version', InputArgument::OPTIONAL, 'Version in form 1.0.0');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $plugin_name = $input->getArgument('plugin_name');
        $author = $input->getArgument('author');
        $version = $input->getArgument('version') ?: '1.0.0';

        $fileNames = $this->wpPluginMaker->createNewPluginFromWpPluginSkeleton($plugin_name, $author, $version);
        foreach ( $fileNames as  $val ){
            $output->writeln('Writing '.$val);
        }
        $output->writeln(sprintf('Success! Plugin with name %s, author %s and version %s is created.', $plugin_name, $author, $version ));

        return Command::SUCCESS;
    }

}