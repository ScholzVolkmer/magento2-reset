<?php

namespace SV\Reset\Console;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResetAll extends ResetCommand
{

    protected function configure()
    {
        $this->setName( 'reset:all' )
            ->addOption( 'force', 'f', InputOption::VALUE_NONE, 'Force if on production.' )
            ->setDescription( 'Reset / remove all customers.' );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        parent::execute( $input, $output );

        $options = new ArrayInput( [ '--force' => true ] );

        try
        {
            $this->getApplication()->find( 'reset:categories' )->run( $options, $output );
            $this->getApplication()->find( 'reset:customers' )->run( $options, $output );
            $this->getApplication()->find( 'reset:orders' )->run( $options, $output );
            $this->getApplication()->find( 'reset:products' )->run( $options, $output );
            $this->getApplication()->find( 'reset:reviews' )->run( $options, $output );
        }
        catch ( \Exception $e )
        {
            $output->write( $e->getMessage() );
            $output->writeln( "<error>There was a problem while resetting the data.</error>" );
        }
    }

}