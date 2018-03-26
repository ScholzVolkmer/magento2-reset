<?php

namespace SV\Reset\Console;

use SV\Reset\Model\Category;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResetCategories extends ResetCommand
{

    protected function configure()
    {
        $this->setName( 'reset:categories' )
            ->addOption( 'force', 'f', InputOption::VALUE_NONE, 'Force if on production.' )
            ->setDescription( 'Reset / remove all categories.' );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        parent::execute( $input, $output );

        $output->writeln( "<comment>Resetting categories ...</comment> " );

        $model = $this->objectManager->get( Category::class );
        $model->reset( $output );
        $model->reindex();
    }

}