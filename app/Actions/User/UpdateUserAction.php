<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Actions\User\Artifacts\AddArtifactsAction;
use App\Interfaces\Actions\UpdateActionInterface;
use Illuminate\Database\Eloquent\Model;

class UpdateUserAction implements UpdateActionInterface {

    public function __construct(private AddArtifactsAction $addArtifactsAction)
    {}
    
    /**
     * @param array $payload
     * @param User $model
     * @return User
     * @throws \Throwable
     */
    public function handle(array $payload, Model $model): Model{
        /** @var User $model */
       DB::beginTransaction();

      try {
          $model->fill(Arr::only($payload, $model->getFillable()));
          $model->save();

          //We are not deleting old artifacts, just adding new ones. To have full history with changes.
          $this->addArtifactsAction->handle($payload['artifacts'] ?? [], $model);

          DB::commit();

          return $model->fresh();
      } catch (\Throwable $e) {
          DB::rollBack();
          throw $e;
      }
    }
}