<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Services\PostService;

class PostController extends Controller
{
    public PostService $postService;
    public UserService $userService;

    public function __construct(PostService $postService, UserService $userService)
    {
        $this->postService = $postService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(FilterPostRequest $request)
    {
        if (isset($request->filters)) {
            $posts = $this->postService->all($request->validated());
        } else {
            $posts = $this->postService->all();
        }

        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $user = $this->userService->getUser($request->api_token);

        $post = $this->postService->store($user, $request->validated());

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->postService->findById($id);

        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = $this->postService->findById($id);

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $user = $this->userService->getUser($request->api_token);
        $post = $this->postService->update($id, $user, $request->validated());

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = $this->postService->destroy($id);
    }
}
