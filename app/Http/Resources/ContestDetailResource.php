<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContestDetailResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'level' => $this->level,
            'author_id' => $this->author,
            'uploader' => $this ->whenLoaded('uploader'),
            'comment_total' => $this->whenLoaded('comments', function(){
                return count($this->comments);
            }),
            'comments' => $this ->whenLoaded('comments', function(){
                return collect($this->comments) -> each(function($comment){
                    $comment -> commentator;
                    return $comment;
                });
            }),
            // 'created_at' => $this->created_at,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
        ];
    }
}
