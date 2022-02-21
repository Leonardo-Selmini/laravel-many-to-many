@extends('layouts.app')

@section('content')
<div class="col">
  <div class="card">
    <div class="card-header">
      <h5 class="d-inline">Create new post</h5>
    </div>
    <div class="card-body">
      <form action="{{route("posts.store")}}" method="POST">
        @csrf

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label class="input-group-text" for="select">Category</label>
          </div>
          <select name="category_id" class="custom-select @error('category_id') is-invalid @enderror" id="select">
            <option value="" selected>Choose a category</option>
            @foreach ($categories as $category)
              <option value="{{$category->id}}" {{old("category_id") == $category->id? "selected" : "" }}>{{$category->name}}</option>
            @endforeach
          </select>
          @error('category_id')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group form-check form-check-inline">
          @foreach ($tags as $tag)
          <input name="tags[]" value="{{$tag->id}}" type="checkbox" class="form-check-input" id="{{$tag->id}}" {{(old(""))? "checked" : "" }}>
          <label class="form-check-label mr-4" for="{{$tag->id}}">{{$tag->name}}</label>
          @endforeach
          @error('tag_id')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="title">Title</label>
          <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Insert a title" value="{{old("title")}}">
          @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="content">Content</label>
          <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" cols="30" rows="10" placeholder="Insert your description">{{old("content")}}</textarea>
          @error('content')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group form-check">
          <input name="posted" type="checkbox" class="form-check-input" id="posted" {{(old("posted"))? "checked" : "" }}>
          <label class="form-check-label" for="posted">Publish</label>
          @error('posted')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create</button>

      </form>
    </div>
  </div>
</div>
@endsection