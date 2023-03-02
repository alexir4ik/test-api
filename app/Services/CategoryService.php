<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }
}
