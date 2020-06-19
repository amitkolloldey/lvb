<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array|Application|ResponseFactory|Response
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'label' => $this->label,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'permissions' => $this->permissions,
            'permission_count' => $this->permissions->count() ? $this->permissions->count() : "No Permission Set"
        ];
    }

}
