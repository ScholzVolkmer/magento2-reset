<?php

namespace SV\Reset\Model;

use SV\Reset\Reset;

class Customer extends Reset
{

    /** @var array */
    protected $tables = [
        'customer_address_entity',
        'customer_address_entity_datetime',
        'customer_address_entity_decimal',
        'customer_address_entity_int',
        'customer_address_entity_text',
        'customer_address_entity_varchar',
        'customer_entity',
        'customer_entity_datetime',
        'customer_entity_decimal',
        'customer_entity_int',
        'customer_entity_text',
        'customer_entity_varchar',
        'wishlist',
        'wishlist_item',
        'wishlist_item_option',
        'report_viewed_product_index',
    ];

    /** @var array */
    protected $indexes = [ 'customer_grid' ];

}