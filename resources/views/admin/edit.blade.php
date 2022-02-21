@extends('layouts.app')

@section('content')
<div class="col">
  <div class="card">
    <div class="card-header">
      <h5 class="d-inline">Edit post</h5>
    </div>
    <div class="card-body">
      <form action="{{route("posts.update", $post->id)}}" method="POST">
        @csrf
        @method("PUT")

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label class="input-group-text" for="select">Category</label>
          </div>
          <select name="category_id" class="custom-select @error('category_id') is-invalid @enderror" id="select">
            <option value="" selected>Choose a category</option>
            @foreach ($categories as $category)
              <option value="{{$category->id}}" {{old("category_id", $post->category_id) == $category->id? "selected" : "" }}>{{$category->name}}</option>
            @endforeach
          </select>
          @error('category_id')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group form-check form-check-inline">
          @foreach ($tags as $tag)
          @if (old("tags"))
          <input name="tags[]" value="{{$tag->id}}" {{in_array($tag->id, old("tags"))? "checked" : ""}} type="checkbox" class="form-check-input" id="{{$tag->id}}">
          @else 
          <input name="tags[]" value="{{$tag->id}}" {{$post->tags->contains($tag)? "checked" : ""}} type="checkbox" class="form-check-input" id="{{$tag->id}}">
          @endif
          <label class="form-check-label mr-4" for="{{$tag->id}}">{{$tag->name}}</label>
          @endforeach
          @error('tag_id')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="title">Title</label>
          <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Insert a title" value="{{old("title")? old("title") : $post->title}}">
          @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="content">Content</label>
          <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" cols="30" rows="10" placeholder="Insert your description">{{old("content")? old("content") : $post->content}}</textarea>
          @error('content')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group form-check">
          @php
            $posted = old("published")? old("published") : $post->posted;
          @endphp
          <input name="posted" type="checkbox" class="form-check-input" id="published" {{$posted? "checked" : ""}}>
          <label class="form-check-label" for="published">Publish</label>
        </div>
        
        <button type="submit" class="btn btn-primary">Edit</button>

      </form>
    </div>
  </div>
</div>
@endsection