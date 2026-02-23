<?php

namespace App\Interfaces\Actions;

use Illuminate\Database\Eloquent\Model;

interface CreateActionInterface
{
    /**
     * Handle the creation of a new resource.
     * @param array $payload
     * @return Model
     */
    public function handle(array $payload): Model;
}