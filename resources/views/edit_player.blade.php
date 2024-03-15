@extends('test')

@section('content')
<div class="container" style="max-width: 45%!important">
  <br>
  <h1>Edit Player</h1>
  <br>
  <div class="card">
    <div class="card-body">
      {{ Form::open() }}
      <div class="form-group">
        <label for="username">Your Name</label>
        <input type="text" value="{{$user->name}}" class="form-control" name='username' placeholder="Enter name" required>
      </div>
      <div class="form-group" style="padding-top: 10px">
        <label>Favourite Color</label>
        <input type="color" style="margin-left: 40px" value="{{$user->fav_color}}" name="fav_color">
      </div>
      <button type="submit" class="btn btn-warning">Edit</button>
      {{ Form::close() }}
    </div>
  </div>
</div>
@endsection