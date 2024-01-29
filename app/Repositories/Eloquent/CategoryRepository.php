<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ICategory;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements ICategory
{
    public function model()
    {
        return Category::class;
    }
}
