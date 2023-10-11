<?php

namespace App\Http\Resources;

use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $choices = array();
        foreach ($this->choices as $choice) {
            $choice['id'] = $choice->uuid;
            $choice['content'] = $choice->content;
            $choice['status'] = $choice->pivot->status;
            $choices[] = $choice;
        }
        return [
            'id' => $this->uuid,
            'content' => $this->content,
            'reference' => $this->reference,
            'subject_name' => $this->subject_name,
            'choices' => ChoiceResource::collection($choices)
        ];
    }
}