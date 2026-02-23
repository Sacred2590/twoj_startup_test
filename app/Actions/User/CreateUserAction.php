<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Actions\User\Artifacts\AddArtifactsAction;
use App\Interfaces\Actions\CreateActionInterface;
use Illuminate\Database\Eloquent\Model;

class CreateUserAction implements CreateActionInterface{

    public function __construct(private AddArtifactsAction $addArtifactsAction)
    {}
    
    /**
     * @param array $payload
     * @return User
     * @throws \Throwable
     */
    public function handle(array $payload): Model {
       DB::beginTransaction();

      try {
        $model = new User();

        $model->fill(Arr::only($payload, $model->getFillable()));
        $model->save();

        $this->addArtifactsAction->handle($payload['artifacts'] ?? [], $model);

        DB::commit();

        //Loading fresh instance to load artifacts relation as well.
        $model = $model->fresh(); 

        return $model;
      } catch (\Throwable $e) {
          DB::rollBack();
          throw $e;
      }
    }
}