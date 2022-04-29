<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get post by title in ascending order
    //    $post=Post::orderBy('title','asc')->get();
    //    if($post){
    //        return response()->json(['success' => true, 'posts' =>$post]);
    //    }


       //using query builder
       $post=DB::table('posts')
        ->select('title')
        // ->orderBy('title','asc')
        ->get();
        if($post){
            return response()->json(['success' => true, 'posts' =>$post]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title'=> 'required',
            'body' => 'required',
            'cover_image' =>'required|nullable|max:5000'
        ]);

        $post = $request->all();

        if ($image = $request->file('cover_image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $post['cover_image'] = "$profileImage";
        }

        Post::create($post);


        return response()->json(['success' => true, 'post' => $post]);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, $id)
    {
        $post=Post::find($id);
        if(Auth::user()->id !==$post->user_id){
            return response()->json(['success' =>false, 'error' =>"You are not allowed to edit this resource"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,post $post, $d)
    {


        $request->validate([
            'title'=> 'required',
            'body' => 'required',
        ]);

        $input = $request->all();

        if ($image = $request->file('cover_image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['cover_image'] = "$profileImage";
        }else{
            unset($input['cover_image']);
        }
        
        $post->update($input);
  
        return response()->json(['success' =>"Post updated successfully",'post'=>$post]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post,$id)
    {
        $post= Post::destroy($id);
        return response()->json(['success' =>"Post deleted successfully"]);

    }
}
