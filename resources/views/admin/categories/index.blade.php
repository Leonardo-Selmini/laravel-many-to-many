@extends('layouts.app')

@section('content')
<div class="col">
  <a href="{{route("categories.create")}}">
    <button type="button" class="btn btn-success mb-3">Create Post</button>
  </a>
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Slug</th>
        <th scope="col"></th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $category)
      <tr>
        <td>{{$category->id}}</td>
        <td>{{$category->name}}</td>
        <td>{{$category->slug}}</td>
        <td>
          <a href="{{route("categories.show", $category->id)}}">
            <button type="button" class="btn btn-outline-info">View</button>
          </a>
        </td>
        <td>
          <a href="{{route("categories.edit", $category->id)}}">
            <button type="button" class="btn btn-primary">Edit</button>
          </a>
        </td>
        <td>
          <form action="{{route("categories.destroy", $category->id)}}" method="POST">
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