<?php

namespace App\Http\Controllers;

use Carbon\Carbon ;

use Illuminate\Http\Request;
use App\Models\Post;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        //$posts=Post::all();
        $posts = Post::orderBy('created_at', 'asc')->paginate(1);

        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:posts|min:3',
            'body' => 'required|min:10'
        ]);

        // $parameters = $request->all();
        //Post::create($parameters);
        //create post

        $insert = [
            'slug' => SlugService::createSlug(Post::class, 'slug', $request->title),
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),

        ];
   
        Post::insertGetId($insert);
       
        return redirect('/home')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //Check if post exists before deleting
        if (!isset($post)) {
            return redirect('/home')->with('error', 'No Post Found');
        }

        // Check for correct user
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/home')->with('error', 'Unauthorized Page');
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'body' => 'required|min:10'
        ]);
        //create post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->save();
        return redirect('/home')->with('success', 'Post updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        //Check if post exists before deleting
        if (!isset($post)) {
            return redirect('/home')->with('error', 'No Post Found');
        }

        // Check for correct user
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/home')->with('error', 'Unauthorized Page');
        }
        $post->delete();
        return redirect('/home')->with('success', 'Post Removed');
    }

    public function showAllDeletedPosts()
    {
        $posts = Post::onlyTrashed()->get();
        return view('posts.deletedposts')->with('posts', $posts);
    }


    public function restoreDeletedPost($id)
    {
        $post = Post::where('id', $id)->withTrashed()->first();
        $post->restore();
        return redirect('/home')->with('success', 'Post restored');
    }


    public function deletePermanently($id)
    {
        $post = Post::where('id', $id)->withTrashed()->first();

        $post->forceDelete();

        return redirect('/home')->with('success', 'Post Deleted Permanently');
    }
}
