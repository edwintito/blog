<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
        $this -> middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
//        $posts = Post::all();
        $posts = Post::orderBy('created_at','desc')->paginate(4);
        return view('posts.index')->with('posts',$posts);
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'title' =>'required',
          'body'=>'required',
            'cover_image'=>'image|nullable|max:1999'
        ]);
//        dd($request->hasFile('cover_image'));
        if ($request->hasFile('cover_image'))
        {
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images',$filenameToStore);
        }
        else{
            $filenameToStore = 'no_image.jpg';
        }


        $post = new Post();
        $post -> title = request('title');
        $post -> body = request('body');
        $post -> user_id = auth()->user()->id;
        $post ->cover_image = $filenameToStore;
        $post ->save();

        return redirect('/posts')->with('msg','Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (auth()->user()->id != $post->user_id)
        {
            return redirect('/posts')->with('msg','Not Allowed');
        }
        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' =>'required',
            'body'=>'required'
        ]);

        if ($request->hasFile('cover_image'))
        {
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images',$filenameToStore);
        }

        $post = Post::findOrFail($id);
        $post -> title = request('title');
        $post -> body = request('body');

        if ($request->hasFile('cover_image'))
        {
            $post->cover_image=$filenameToStore;
        }

        $post ->save();

        return redirect('/posts')->with('msg','Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (auth()->user()->id != $post->user_id)
        {
            return redirect('/posts')->with('msg','Not Allowed');
        }
        if ($post->cover_image != 'no_image.jpg')
        {
            Storage::delete('public/cover_images'.$post->cover_image);
        }

        $post -> delete();
        return redirect('/posts');
    }
}
