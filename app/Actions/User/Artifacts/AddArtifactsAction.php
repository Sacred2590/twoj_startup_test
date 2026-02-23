<?php

namespace App\Actions\User\Artifacts;

use App\Models\User;
use App\Interfaces\Actions\UpdateActionInterface;
use Illuminate\Database\Eloquent\Model;

class AddArtifactsAction implements UpdateActionInterface {

    /**
     * @param array $artifacts  
     * @param Model $model
     * @return Model
     */
    public function handle(array $artifacts, Model $model): Model {
        /** @var User $model */
        $model->artifacts()->createMany($artifacts);

        return $model;
    }
}