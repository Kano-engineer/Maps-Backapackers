@section('aside')
<aside>
    <div class="card-body">
  <h2>USER_NAME</h2>
  <a href="{{action('TargetController@index')}}">
    <button class="btn btn-danger" type="submit">newpost</button>
</a>
<div class="card-body">
    <div>
<p>everyone's post</p>
</div>
</div>

</aside>
@endsection
