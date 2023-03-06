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

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::class;

        // return view('categories.index',compact('categories'));

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('title', 'LIKE', "%{$value}%")
                        ->orWhere('slug', 'LIKE', "%{$value}%");
                });
            });
        });

        $posts = QueryBuilder::for(Post::class)
            ->defaultSort('title')
            ->allowedSorts(['title', 'slug'])
            ->allowedFilters(['title', 'slug', 'category_id', $globalSearch]);

        $categories = Category::pluck('name', 'id')->toArray();
        return view('posts.index', [
            'posts' => SpladeTable::for($posts)
                ->column('title', sortable: true,)
                ->column('slug', label: 'Description', searchable: true)
                ->column('action')
                ->withGlobalSearch(columns: ['title', 'slug'])
                ->selectFilter('category_id', $categories)
                ->paginate(8),
        ]);
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
