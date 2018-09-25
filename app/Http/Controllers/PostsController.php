<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
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
        $this->middleware('auth' , ['except' => ['index','show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
       // $posts =  Post::all();
       // $posts = DB::select('select * from posts');
        //$posts = Post::orderBy('id', 'DESC')->get();
        $posts = Post::orderBy('id', 'DESC')->paginate(10);
        return view('posts.index')->with('title', 'Post Pages')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('title', 'Çreate a new Post');
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
            'title' => 'required',
            'body' => 'required',
            'cover_image' =>'image|nullable|max:1999'
        ]);

        //handle image upload

        if($request->hasFile('cover_image')){
            //Get file name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

            //GEt just Filename
            $filename = pathInfo($fileNameWithExt, PATHINFO_FILENAME);

            //Get Just Ext.
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $fileNameToStore = time().'.jpg';
        
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }
        $post = new Post();

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Your post has been successfully Created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $post =  Post::find($id);
       return view('posts.show')->with('post', $post)->with('title', 'Post Desciption');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post =  Post::find($id);

        // for authorizing user before edit post
        if(auth()->user()->id != $post->user_id){
        return redirect('/posts')->with('error', 'Unauthorized user');
        }

        return view('posts.edit')->with('post', $post)->with('title', 'Edit POst');
    }

    public function update(Request $request, $id)
    {
        //handle image upload

        if($request->hasFile('cover_image')){
            //Get file name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

            //GEt just Filename
            $filename = pathInfo($fileNameWithExt, PATHINFO_FILENAME);

            //Get Just Ext.
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $fileNameToStore = time().'.jpg';
        
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        $post =  Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Your post has been successfully updated');
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post =  Post::find($id);

         // for authorizing user before edit post
        if(auth()->user()->id != $post->user_id){
        return redirect('/posts')->with('error', 'Unauthorized user');
        }
        
        if($post->cover_image != 'noimage.jpg'){
            Storage::delete('public\cover_images'.$post->cover_image);
        }
            
        $post->delete();

        return redirect('/posts')->with('success', 'Your post has been successfully deleted');
    }
}
