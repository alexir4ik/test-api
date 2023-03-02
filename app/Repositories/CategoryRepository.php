<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class CategoryRepository
{
    public Model $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }
}
