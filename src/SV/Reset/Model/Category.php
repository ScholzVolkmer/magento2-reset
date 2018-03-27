<?php

namespace SV\Reset\Model;

use SV\Reset\Reset;

class Category extends Reset
{

    /** @var array */
    protected $tables = [
        'catalog_category_entity',
        'catalog_category_entity_datetime',
        'catalog_category_entity_decimal',
        'catalog_category_entity_int',
        'catalog_category_entity_text',
        'catalog_category_entity_varchar',
        'catalog_category_product',
        'catalog_category_product_index',
        'catalog_category_product_index_replica',
        'catalog_category_product_index_tmp',
        'catalog_url_rewrite_product_category',
    ];

    /** @var array */
    protected $indexes = [ 'catalog_category_product', 'catalog_product_category' ];

    /** @var string */
    protected $rewriteType = 'category';


    public function runAfter() : void
    {
        $table = $this->getTableName( 'catalog_category_entity' );

        $this->getConnection()->query(
            "INSERT INTO {$table} " .
            "    (entity_id, attribute_set_id, parent_id, created_at, updated_at, " .
            "    path, position, level, children_count) " .
            "VALUES (1, 0, 0, NOW(), NOW(), '1', 0, 0, 1), " .
            "    (2, 3, 1, NOW(), NOW(), '1/2', 1, 1, 0);" );

        // TODO: fetch attribute_id before
        $table = $this->getTableName( 'catalog_category_entity_text' );
        $this->getConnection()->query(
            "INSERT INTO {$table} " .
            "    (`value_id`, `attribute_id`, `store_id`, `entity_id`, `value`) " .
            "VALUES (1, 47, 0, 1, '<p>Root Category content</p>'), " .
            "    (2, 47, 0, 2, '<p>Sub Category content</p>'); " );

        // TODO: fetch attribute_id before
        $table = $this->getTableName( 'catalog_category_entity_varchar' );
        $this->getConnection()->query(
            "INSERT INTO {$table} " .
            "    (`value_id`, `attribute_id`, `store_id`, `entity_id`, `value`) " .
            "VALUES (1, 45, 0, 1, 'Root Catalog'), (2, 45, 0, 2, 'Default Category'); " );

    }

}