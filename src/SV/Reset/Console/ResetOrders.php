<?php

namespace SV\Reset\Console;

use SV\Reset\Model\Order;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResetOrders extends ResetCommand
{

    protected function configure()
    {
        $this->setName( 'reset:orders' )
            ->addOption( 'force', 'f', InputOption::VALUE_NONE, 'Force if on production.' )
            ->setDescription( 'Reset / remove all orders.' );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        parent::execute( $input, $output );

        $output->writeln( "<comment>Resetting orders ...</comment> " );

        $model = $this->objectManager->get( Order::class );
        $model->reset( $output );
    }

}