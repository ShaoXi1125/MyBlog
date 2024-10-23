<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Image;

use Illuminate\Http\Request;

class PostController extends Controller
{

  public function index(){

    // $posts = Post::all();
    $posts = Post::with('image')->get();
    return view('posts.index', compact('posts'));
  }

  public function viewer(){

    // $posts = Post::all();
    $posts = Post::with('image')->get();
    return view('show.index', compact('posts'));
  }

  public function show($id){
    $post = Post::with('image')->findOrFail($id);
    return view('posts.show',compact('post'));
  }
  
  public function edit($id){
    $post = Post::with('image')->findOrFail($id);
    return view('posts.edit',compact('post'));
  }

  public function update(Request $request, $id){
    $request->validate([
        'title' => 'required',
        'content'=>'required',
        'image.*'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $post = Post::findOrFail($id);
    $post->update([
      'title' => $request->title,
      'content' => $request->content,
    ]);


    if($request->has('remove_image')){
      foreach($request->remove_image as $imageId){
        $image = Image::find($imageId);
        if($image){
          $image->delete();
        }
      }
    }

    if ($request->hasFile('images')) {
      foreach ($request->file('images') as $imageFile) {
          // 调试信息，检查是否多个文件上传成功

          $imageName = time() . '_' . $imageFile->getClientOriginalName();
          $imagePath = public_path('images');
          $imageFile->move($imagePath, $imageName);
  
          Image::create([
              'image' => 'images/' . $imageName,
              'post_id' => $post->id
          ]);
      }
    }
    $post->update($request->all());
    return redirect()->route('posts.index');
  }

  public function delete($id){
    $post = Post::with('image')->findOrFail($id);
    $post->delete();
    return redirect()->route('posts.index');
  }



  public function store(Request $request) {

    // 验证请求
    $request->validate([
        'title' => 'required',
        'content' => 'required',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // 验证每个图片
    ]);

    // 创建帖子
    $post = Post::create([
        'title' => $request->title,
        'content' => $request->content,
    ]);

    // 检查是否接收到图片数组
    if ($request->hasFile('images')) {
      foreach ($request->file('images') as $imageFile) {
          // 调试信息，检查是否多个文件上传成功

  
          $imageName = time() . '_' . $imageFile->getClientOriginalName();
          $imagePath = public_path('images');
          $imageFile->move($imagePath, $imageName);
  
          Image::create([
              'image' => 'images/' . $imageName,
              'post_id' => $post->id
          ]);
      }
    } else {
        // 调试：检查未接收到图片时的情况
        dd("No images received");
    }

    return redirect()->route('posts.index');
}



  public function new_post(){
    return view('posts.new_post');
  }


}
