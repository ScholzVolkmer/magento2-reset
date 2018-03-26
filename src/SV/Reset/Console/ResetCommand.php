<?php

namespace SV\Reset\Console;

use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Magento\Framework\ObjectManagerInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class ResetCommand extends Command
{

    /** @var ObjectManagerInterface */
    protected $objectManager;

    public function __construct( ObjectManagerInterface $objectManager )
    {
        $this->objectManager = $objectManager;

        parent::__construct();
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $state = $this->objectManager->get( State::class );

        if ( $state->getMode() == State::MODE_PRODUCTION )
        {
            throw new RuntimeException( "Entities can't be reset in production mode." );
        }

        if ( $input->getOption( 'force' ) ) return;

        $helper = $this->getHelper( 'question' );
        $question = new ConfirmationQuestion(
            'Do you really want to reset the data? ', false, '/^(y|j)/i'
        );

        if ( $helper->ask( $input, $output, $question ) ) return;

        $output->writeln( "<comment>Command aborted.</comment>" );
        exit;
    }

}