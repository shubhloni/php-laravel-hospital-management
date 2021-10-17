<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostsController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth', ['except'=>['index','show']]);
  }
  /**
   * Display a Listing of all Resources
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $posts = Post::all();
    return view('posts.index')->with('posts',$posts);
  }

  public function create()
  {
    return view('posts.create');
  }

/**
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/
  public function store(Request $request)
  {
    $this->validate($request,[
      'title'  => 'required',
      'body' => 'required',
      'cover_image' => 'image|nullable|max:1999'
    ]);

    //Handle File Upload
    if ($request->hasFile('cover_image')) {
      //Get File Name Ext
      $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
      //Get only File Name
      $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
      //Get only ext
      $ext = $request->file('cover_image')->getClientOriginalExtension();
      //Actual File Name
      $fileNameToStore = $fileName .'_'.time().'.'.$ext;
      //Upload Image
      $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
    }else {
      $fileNameToStore = 'noimage.jpg';
    }

    $post = new Post;
    $post->title = $request->input('title');
    $post->body = $request->input('body');
    $post->user_id = auth()->user()->id;
    $post->cover_image = $fileNameToStore;
    $post->save();

    return redirect('/posts')->with('success','Post Submitted!!');
  }

  public function show($id)
  {
    $post = Post::find($id);
    return view('posts.show')->with('post',$post);
  }

  public function edit($id)
  {
    $post = Post::find($id);
    if (auth()->user()->id !== $post->user_id) {
      return redirect('home')->with('error','Unauthorized Post');
    }
    return view('posts.edit')->with('post',$post);
  }

  public function update(Request $request,$id)
  {
    $this->validate($request,[
      'title'  => 'required',
      'body' => 'required',
      'cover_image' => 'image|nullable|max:1999'
    ]);

    //Handle File Upload
    if ($request->hasFile('cover_image')) {
      //Get File Name Ext
      $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
      //Get only File Name
      $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
      //Get only ext
      $ext = $request->file('cover_image')->getClientOriginalExtension();
      //Actual File Name
      $fileNameToStore = $fileName .'_'.time().'.'.$ext;
      //Upload Image
      $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
    }

    $post = Post::find($id);
    $post->title = $request->input('title');
    $post->body = $request->input('body');
    if ($request->hasFile('cover_image')) {
          $post->cover_image = $fileNameToStore;
    }
    $post->save();

    return redirect('/posts')->with('success','Post Updated!!');
  }rn

  public function destroy($id)
  {
    $post = Post::find($id);
    if (auth()->user()->id !== $post->user_id) {
      return redirect('home')->with('error','Unauthorized Post');
    }

    if ($post->cover_image !== 'noimage.jpg' ) {
      Storage::delete('public/cover_images/'.$post->cover_image);
    }

    $post->delete();
    return redirect('/posts')->with('success','Post Removed!!');
  }

}
