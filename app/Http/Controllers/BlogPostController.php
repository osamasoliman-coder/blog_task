<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = BlogPost::where('is_public', true);

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        if ($request->has('author')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->author . '%');
            });
        }

        $posts = $query->latest()->paginate(10);
        return view('blog.index', compact('posts'));
    }


    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'is_public' => 'boolean',
        ]);

        $post = new BlogPost();
        $post->user_id = Auth::id();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->is_public = $request->input('is_public');
        $post->save();

        return redirect()->route('blog.index')->with('success', 'Post created successfully');
    }

    public function show($blogPostId)
    {
        $blogPost = BlogPost::find($blogPostId);
        return view('blog.show', compact('blogPost'));
    }

    public function edit(BlogPost $blogPost)
    {
        $this->authorize('update', $blogPost);
        return view('blog.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $this->authorize('update', $blogPost);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'is_public' => 'boolean',
        ]);

        $blogPost->update($request->all());

        return redirect()->route('blog.index')->with('success', 'Post updated successfully');
    }

    public function destroy($blogPostId)
    {
        $blogPost = BlogPost::find($blogPostId);
        $blogPost->delete();

        return redirect()->route('blog.index')->with('success', 'Post deleted successfully');
    }


    public function like($blogPostId)
    {
        $blogPost = BlogPost::find($blogPostId);
        $blogPost->likes()->create([
            'user_id' => Auth::id(),
        ]);
        return back();
    }
}
