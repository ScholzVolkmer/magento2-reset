<?php

namespace SV\Reset;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Event\ManagerInterface;
use Magento\Indexer\Model\IndexerFactory;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Reset
{

    /** @var array */
    protected $tables = [];

    /** @var array */
    protected $indexes = [];

    /** @var ResourceConnection */
    protected $_resource;

    /** @var AdapterInterface */
    protected $_connection;

    /** @var IndexerFactory */
    protected $_indexerFactory;

    /** @var ManagerInterface */
    protected $_eventManager;

    /** @var OutputInterface */
    protected $_output;

    /** @var ProgressBar */
    protected $_progressBar;

    /** @var string */
    protected $rewriteType;

    /**
     * AbstractReset constructor.
     * @param ResourceConnection $resource
     * @param IndexerFactory $indexerFactory
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        ResourceConnection $resource,
        IndexerFactory $indexerFactory,
        ManagerInterface $eventManager )
    {
        $this->_resource       = $resource;
        $this->_indexerFactory = $indexerFactory;
        $this->_eventManager   = $eventManager;
    }

    /**
     * @return AdapterInterface
     */
    protected function getConnection() : AdapterInterface
    {
        if ( $this->_connection ) return $this->_connection;

        return $this->_connection = $this->_resource->getConnection();
    }

    /**
     * @return array
     */
    protected function getTables() : array
    {
        return $this->tables;
    }

    /**
     * @param string $table
     * @return string
     */
    protected function getTableName( string $table ) : string
    {
        return $this->_resource->getTableName( $table );
    }

    /**
     * @param int $step
     */
    protected function advanceProgressBar( int $step = 1 ) : void
    {
        if ( ! $this->_output || ! $this->_progressBar ) return;

        $this->_progressBar->advance( $step );
    }

    protected function runAfter() : void {}

    protected function initializeOutput() : void
    {
        if ( ! $this->_output ) return;

        $total = count( $this->tables );

        // correct URL rewrites
        if ( $this->rewriteType ) $total++;

        // runAfter
        $total++;

        $this->_progressBar = new ProgressBar( $this->_output, $total );
        $this->_progressBar->setFormat(
            '%current%/%max% [%bar%] %percent:3s%% %elapsed% %memory:6s%'
        );
        $this->_progressBar->start();
        $this->_progressBar->display();
    }

    /**
     * @param OutputInterface $output
     */
    public function reset( OutputInterface $output = null ) : void
    {
        if ( empty( $this->tables ) ) return;

        $this->_output = $output;
        $this->initializeOutput();

        foreach ( $this->tables as $table )
        {
            $table = $this->getTableName( $table );
            $this->getConnection()->query( "SET FOREIGN_KEY_CHECKS = 0;" );

            try
            {
                // ignore any non-existing tables
                $this->getConnection()->query( "TRUNCATE TABLE {$table}; " );
            }
            catch ( \Exception $e ) {}

            $this->getConnection()->query( "SET FOREIGN_KEY_CHECKS = 1;" );
            $this->advanceProgressBar();
        }

        if ( $this->rewriteType )
        {
            $table = $this->getTableName( 'url_rewrite' );
            $this->getConnection()
                ->query( "DELETE FROM {$table} WHERE entity_type = '{$this->rewriteType}'; " );
        }

        $this->runAfter();

        $this->_progressBar->finish();
        $this->_output->writeln( "\n<info>Reset successful.</info>" );
    }

    public function reindex() : void
    {
        if ( empty( $this->indexes ) ) return;

        $this->_output->write( "<comment>Reindexing ...</comment> " );

        foreach ( $this->indexes as $index )
        {
            $indexer = $this->_indexerFactory->create();
            $indexer->load( $index );
            $indexer->reindexAll();
        }

        $this->_output->writeln( "<info>done!</info>" );
    }

}