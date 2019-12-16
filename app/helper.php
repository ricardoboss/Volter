<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

if (! function_exists('get_table_cols')) {
    /**
     * Get model attributes from database columns.
     *
     * @param string $modelClass
     *
     * @return array|null
     */
    function get_table_cols(string $modelClass): ?array
    {
        /** @var Model $m */
        $m = new $modelClass();

        return Schema::getColumnListing($m->getTable());
    }
}

if (! function_exists('get_model_attrs')) {
    /**
     * Get model attributes from database columns.
     *
     * @param string $modelClass
     *
     * @return array|null
     */
    function get_model_attrs(string $modelClass): ?array
    {
        /** @var Model $m */
        $m = new $modelClass();

        return $m->getFillable();
    }
}
