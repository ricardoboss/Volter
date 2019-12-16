<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait PrintModel.
 *
 *
 * @method void table($headers, $rows, $tableStyle = 'default', array $columnStyles = [])
 */
trait ShowModel
{
    /**
     * Print a table with only the headers and one row containing the given attributes.
     */
    public function show(Model $model, array $attributes): void
    {
        $this->table($attributes, [$model->only($attributes)]);
    }
}
