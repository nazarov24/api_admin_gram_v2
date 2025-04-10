<?php

namespace App\Http\Resources\User;

use App\Models\Employee;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatedUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->whenPivotLoadedAs('employee', Employee::class, function() {
                return $this->employee->id;
            },function() {
                return $this->id. " No employee";
            }),
            'full_name' => $this->first_name." ".$this->last_name,
            'login' => $this->login,
            'role' => $this->roles()->pluck('display_name')[0] ?? 'driver'
        ];
    }
}
