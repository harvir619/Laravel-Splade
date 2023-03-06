<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\PostStoreRequest;
use App\Tables\Posts;

class PostController extends Controller
{
    public function index()
    {
        return view(
            'posts.index',
            [
                // 'posts' => SpladeTable::for($posts)
                'posts' => Posts::class,
            ]
        );
    }


    public function create()
    {
        $categories = Category::pluck('name', 'id')->toArray();
        return view('posts.create', compact('categories'));
    }

    public function store(PostStoreRequest $request)
    {
        Post::create($request->validated());
        Toast::title('Post has been created');
        return redirect()->route('posts.index');
    }


    public function edit(Post $post)
    {
        $categories = Category::pluck('name', 'id')->toArray();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(PostStoreRequest $request, Post $post)
    {

        $post->update($request->validated());
        Toast::title('Post Updated Succesfully');

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        Toast::success('Post Deleted Succesfully');

        return redirect()->back();
    }
}
