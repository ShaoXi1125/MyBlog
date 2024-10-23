@extends('layout.app')

@section('title','Update Post')

@section('content')

<div class='container'>
    <form action="{{route('posts.update',$post->id)}}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label><br>
            <input type="text" name="title" id="title" class="form-control" value='{{$post->title}}'>
        </div>

        <div class="form-group">
            <label for="content">Content</label><br>
            <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{$post->content}}</textarea>
        </div>
        @if($post->image)
        @foreach($post->image as $images)
           <figure class='card-img-top'>
               <img src="{{asset($images->image)}}" alt="Post Image" style="width:20%;">
               <label for="remove_image"><input type='checkbox' name='remove_image[]' value='{{$images->id}}'> Remove Image</label>
           </figure>
        @endforeach
        @endif
        <!-- 图片上传字段的容器 -->
        <div class="form-group">
            <label for="image">Images</label><br>
            <div id="image-upload-fields">
                <!-- 第一个上传框，手动放置 -->
                <div class="image-upload-group" id="upload-group-0" style="position: relative;">
                    <input type="file" name="images[]" id="image-upload-0" class="form-control" accept="image/*" onchange="previewImage(this, 0); showNextUploadField(1)">
                    <img id="preview-0" style="width: 200px; margin-top: 10px; display: none; position: relative;">
                    <!-- 取消按钮（打叉） -->
                    <span class="remove-btn" id="remove-0" style="display:none;" onclick="removeUploadField(0)">×</span>
                </div>
            </div>
        </div>
        <br>
        

        <div class='form-group'>
            <button type="submit">Update Post</button>
        </div>

    </form>
</div>

@endsection

@section('scripts')
    <!-- 引入自定义的JS文件 -->
    <script src="{{ asset('js/image-upload.js') }}"></script>
@endsection
