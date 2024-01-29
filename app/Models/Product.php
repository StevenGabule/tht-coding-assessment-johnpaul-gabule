<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'code', 'description', 'excerpt', 'unit', 'is_active', 'category_ids'];

    public function product_categories() {
        return Category::whereIn('id', explode(',', $this->category_ids))->get();
    }
}
