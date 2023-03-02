<?php

namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    public function __construct(PostRepository $repo)
    {
        $this->repo = $repo;
    }

    public function findById($id)
    {
        return $this->repo->findById($id);
    }

    public function all($filters = null)
    {
        if ($filters != null) {

            return $this->repo->sortByField($filters);
        } else {
            return $this->repo->all();
        }
    }

    public function store($user, array $data)
    {
        $post = $this->repo->create($user, $data);

        $this->repo->attachData($post, $data['categories']);

        return $post;
    }

    public function update($id, $user, $data)
    {
        $post = $this->findById($id);
        $post = $this->repo->update($post, $user, $data);

        $this->repo->syncData($post, $data['categories']);

        return $post;
    }

    public function destroy($id)
    {
        return $this->repo->destroy($id);
    }
}
