<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserArtifactResource extends JsonResource
{
    /**
     * @return list<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'artifact_name' => $this->artifact_name,
            'artifact_value' => $this->artifact_value,
        ];
    }
}
