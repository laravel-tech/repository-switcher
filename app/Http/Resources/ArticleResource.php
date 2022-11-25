<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $heading
 * @property string $slug
 * @property string $content
 * @property string $title
 * @property string $description
 * @property int $status
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  array
     */
    public function toArray($request)
    {
        return [
            'heading'		=> $this->heading,
            'slug'			=> $this->slug,
            'content'		=> $this->content,
            'title'			=> $this->title,
            'description'	=> $this->description,
            'status'		=> $this->status,
        ];
    }
}
