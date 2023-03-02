<?php


namespace App\Repositories;

use App\Models\Post;
use \Illuminate\Database\Eloquent\Model;

class PostRepository
{
    public Model $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create($user, $data)
    {
        $post = $this->model->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'content' => $data['content'],
            'image' => $data['image'],
            'user_id' => $user->id
        ]);

        return $post;
    }

    public function attachData($post, $categories)
    {
        return $post->categories()->attach($categories);
    }

    public function syncData($post, $categories)
    {
        return $post->categories()->sync($categories);
    }

    public function update($post, $user, $data)
    {
        $post->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'content' => $data['content'],
            'image' => $data['image'],
            'user_id' => $user->id,
        ]);

        return $post;
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function sortByField($filters)
    {
        $posts = $this->model;

        if (isset($filters['search'])) {
            $posts = $this->searchMultipleColumn($posts, $filters['search']);
        }

        return $posts->orderBy($filters['columnName'], $filters['typeSort'])->get();
    }

    public function searchMultipleColumn($posts, $search)
    {
        return $posts->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('description', 'LIKE', '%' . $search . '%')
            ->orWhere('content', 'LIKE', '%' . $search . '%');
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }
}
