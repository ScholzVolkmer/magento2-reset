<?php

namespace SV\Reset\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Event\ManagerInterface;
use Magento\Indexer\Model\IndexerFactory;
use Magento\Store\Model\StoreManagerInterface;
use SV\Reset\Reset;

class Order extends Reset
{

    /** @var array */
    protected $tables = [
        'email_order',
        'paypal_billing_agreement_order',
        'reporting_orders',
        'report_event',
        'salesrule_coupon_aggregated_order',
        'sales_invoiced_aggregated_order',
        'sales_order',
        'sales_order_address',
        'sales_order_aggregated_created',
        'sales_order_aggregated_updated',
        'sales_order_grid',
        'sales_order_item',
        'sales_order_payment',
        'sales_order_status',
        'sales_order_status_history',
        'sales_order_status_label',
        'sales_order_status_state',
        'sales_order_tax',
        'sales_order_tax_item',
        'sales_bestsellers_aggregated_daily',
        'sales_bestsellers_aggregated_monthly',
        'sales_bestsellers_aggregated_yearly',
        'sales_creditmemo',
        'sales_creditmemo_comment',
        'sales_creditmemo_grid',
        'sales_creditmemo_item',
        'sales_invoice',
        'sales_invoiced_aggregated',
        'sales_invoiced_aggregated_order',
        'sales_invoice_comment',
        'sales_invoice_grid',
        'sales_invoice_item',
        'sales_payment_transaction',
        'sales_refunded_aggregated',
        'sales_refunded_aggregated_order',
        'sales_shipment',
        'sales_shipment_comment',
        'sales_shipment_grid',
        'sales_shipment_item',
        'sales_shipment_track',
        'sales_shipping_aggregated',
        'sales_shipping_aggregated_order',
        'sequence_order_0',
        'sequence_order_1',
        'sequence_order_2',
        'sequence_order_3',
        'tax_order_aggregated_created',
        'tax_order_aggregated_updated',
        'temando_order',
        'vault_payment_token_order_payment_link',
        'quote',
        'quote_address',
        'quote_address_item',
        'quote_id_mask',
        'quote_item',
        'quote_item_option',
        'quote_payment',
        'quote_shipping_rate',
    ];

    /** @var array */
    protected $indexes = [];

    /** @var string */
    protected $rewriteType = 'product';

    /** @var StoreManagerInterface */
    protected $_storeManager;


    public function __construct(
        ResourceConnection $resource,
        IndexerFactory $indexerFactory,
        StoreManagerInterface $storeManager,
        ManagerInterface $eventManager )
    {
        parent::__construct( $resource, $indexerFactory, $eventManager );

        $this->_storeManager = $storeManager;
    }

    /**
     * @return array
     */
    protected function getTables() : array
    {
        $tables = $this->tables;

        foreach ( $this->_storeManager->getStores( true ) as $store )
        {
            foreach ( [ 'invoice', 'order', 'shipment', 'creditmemo' ] as $type )
            {
                $tables[] = 'sequence_' . $type . '_' . $store->getId();
            }
        }

        return $tables;
    }

}