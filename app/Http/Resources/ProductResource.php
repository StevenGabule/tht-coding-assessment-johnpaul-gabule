<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'description' => $this->description,
            'excerpt' => $this->excerpt,
            'unit' => $this->unit,
            'is_active' => $this->is_active,
            'category_ids' => $this->product_categories(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
