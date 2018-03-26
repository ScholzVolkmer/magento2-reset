<?php

namespace SV\Reset\Console;

use SV\Reset\Model\Review;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResetReviews extends ResetCommand
{

    protected function configure()
    {
        $this->setName( 'reset:reviews' )
            ->addOption( 'force', 'f', InputOption::VALUE_NONE, 'Force if on production.' )
            ->setDescription( 'Reset / remove all reviews.' );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        parent::execute( $input, $output );

        $output->writeln( "<comment>Resetting reviews ...</comment> " );

        $model = $this->objectManager->get( Review::class );
        $model->reset( $output );
    }

}