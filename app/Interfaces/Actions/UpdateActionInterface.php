<?php

namespace App\Interfaces\Actions;

use Illuminate\Database\Eloquent\Model;

interface UpdateActionInterface
{
    /**
     * Handle the update of an existing resource.
     * @param array $payload
     * @param Model $model
     * @return Model
     */
    public function handle(array $payload, Model $model): Model;
}