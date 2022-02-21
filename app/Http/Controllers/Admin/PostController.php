<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;
use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categories = Category::all();
      $posts = Post::all();
      return view("admin.index", compact("posts", "categories"));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $categories = Category::all();
      $tags = Tag::all();
      return view("admin.create", compact("categories", "tags"));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd($request);
      // validation
      $request->validate([
        "title" => "required|string|max:100",
        "content" => "required|string",
        "published" => "sometimes|accepted",
        "category_id" => "nullable|exists:categories,id",
        "tags" => "nullable|exists:tags,id"
      ]);
      // create
      $data = $request->all();
      
      $newPost = New Post;
      $newPost->title = $data["title"];
      

      $slug = Str::of($newPost->title)->slug("-");
      $counter = 1;
      while(Post::where("slug", $slug)->first()) {
        $slug .= "-$counter";
        $counter++;
      }
      $newPost->slug = $slug;

      $newPost->content = $data["content"];
      $newPost->posted = isset($data["posted"]);
      $newPost->category_id = $data["category_id"];

      $newPost->save();

      // salvo i dati dei tag nella tabella ponte
      if(isset($data["tags"])){
        $newPost->tags()->sync($data["tags"]);
      }

      // redirect
      return redirect()->route("posts.show", $newPost->id);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
      return view("admin.show", compact("post"));
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
      $categories = Category::all();
      $tags = Tag::all();
      return view("admin.edit", compact("post", "categories", "tags"));
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
         // validation
        $request->validate([
          "title" => "required|string|max:100",
          "content" => "required|string",
          "published" => "sometimes|accepted",
          "tags" => "nullable|exists:tags,id"
        ]);
        // create
        $data = $request->all();
        
        // se cambia il titolo lo aggiorno
        if($data["title"] != $post->title){
          $post->title = $data["title"];
          $slug = Str::of($post->title)->slug("-");
          $counter = 1;
          while(Post::where("slug", $slug)->first()) {
            $slug .= "-$counter";
            $counter++;
          }
          $post->slug = $slug;
        }
  
        $post->content = $data["content"];
        $post->posted = isset($data["posted"]);
        $post->category_id = $data["category_id"];
  
        $post->save();

        $post->tags()->sync($data["tags"]);

        // redirect
        return redirect()->route("posts.show", $post->id);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
      $post->delete();
      return redirect()->route("posts.index");
    }
}
