<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserArtifactResource;

class UserResource extends JsonResource
{
    /**
     * @return list<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'artifacts' => $this->whenLoaded('artifacts', function () {
                return UserArtifactResource::collection($this->artifacts);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
