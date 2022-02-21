@extends('layouts.app')

@section('content')
<div class="col">
  <a href="{{route("posts.create")}}">
    <button type="button" class="btn btn-success mb-3">Create Post</button>
  </a>
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Category</th>
        <th scope="col">Title</th>
        <th scope="col">Slug</th>
        <th scope="col">Description</th>
        <th scope="col"></th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($posts as $post)
      <tr>
        <th scope="row">{{$post->id}}</th>
        <th scope="row">{{isset($post->category->name)? $post->category->name : ""}}</th>
        <td><strong>{{$post->title}}</strong></td>
        <td>{{$post->slug}}</td>
        <td>{{$post->content}}</td>
        <td>
          <a href="{{route("posts.show", $post->id)}}">
            <button type="button" class="btn btn-outline-info">View</button>
          </a>
        </td>
        <td>
          <a href="{{route("posts.edit", $post->id)}}">
            <button type="button" class="btn btn-primary">Edit</button>
          </a>
        </td>
        <td>
          <form action="{{route("posts.destroy", $post->id)}}" method="POST">
            @csrf
            @method("DELETE")
            <button type="sumbit" class="btn btn-secondary">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection