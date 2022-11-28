<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ticket extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status'=>200,
            'data'=>[
                'name'=>$this->name,
                'email'=>$this->email,
                'subject'=>$this->subject,
                'body'=>$this->body,
                
            ]
        ];
    }
}
