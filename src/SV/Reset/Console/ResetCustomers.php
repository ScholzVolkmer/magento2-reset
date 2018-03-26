<?php

namespace SV\Reset\Console;

use SV\Reset\Model\Customer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResetCustomers extends ResetCommand
{

    protected function configure()
    {
        $this->setName( 'reset:customers' )
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

        $output->writeln( "<comment>Resetting customers ...</comment> " );

        $model = $this->objectManager->get( Customer::class );
        $model->reset( $output );
        $model->reindex();
    }

}