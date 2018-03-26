<?php

namespace SV\Reset\Console;

use SV\Reset\Model\Product;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResetProducts extends ResetCommand
{

    protected function configure()
    {
        $this->setName( 'reset:products' )
            ->addOption( 'force', 'f', InputOption::VALUE_NONE, 'Force if on production.' )
            ->setDescription( 'Reset / remove all products.' );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        parent::execute( $input, $output );

        $output->writeln( "<comment>Resetting products ...</comment> " );

        $model = $this->objectManager->get( Product::class );
        $model->reset( $output );
        $model->reindex();
    }

}