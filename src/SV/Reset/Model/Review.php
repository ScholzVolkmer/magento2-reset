<?php

namespace SV\Reset\Model;

use SV\Reset\Reset;

class Review extends Reset
{

    /** @var array */
    protected $tables = [
        'rating_option_vote',
        'rating_option_vote_aggregated',
        'review',
        'review_detail',
        'review_entity_summary',
        'review_store',
    ];

}