@extends('master_layout.master')
@section('Title', 'Book Subjects')
@section('content')
<h2 style="text-align: center;">Book Subjects</h2>

<div class="panel panel-default">
@if (session('success'))
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  {{ session('success') }}
</div>
@endif
</div>

<div>
<form style="margin:auto;max-width:300px">
    <input type="search" class="form-control mr-sm-2" placeholder="Search Books" name="search"  value="{{ request('search') }}">
    <input class="btn btn-primary my-2 my-sm-0" type="submit" value="Search">
</form>
</div>

@if($user->type == 'technician librarian')
<a class="btn btn-primary my-2 my-sm-0" href="{{ route('pendingTags') }}">Filter Pending Subjects</a>
@endif

<table class="table table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
  <th>Department</th>
        <th>Book Barcode</th>
        <th>Suggested Tags</th>
        <th>Status</th>
        <th>Actions</th>
  </tr>
</thead>
@if($user->type == 'technician librarian')
@forelse($tags as $tag)
<tbody>
  <tr align="center">
        <td>{{$tag->department}}</td>
        <td>{{$tag->book_barcode}}</td>
        <td>{{$tag->suggest_book_subject}}</td>

    <td>@foreach($users as $user)
      @if($user->id == $tag->user_id)
      {{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}
      @endif
      @endforeach
    </td>
    <td>
      @if($tag->type == 'technician librarian')
      Technician Librarian
      @elseif($tag->type == 'staff librarian')
      Staff Librarian
      @elseif($tag->type == 'department representative')
      Department Representative
      @endif
    </td>
    <td>{{$tag->department}}</td>
    <td>
      @if($tag->status == 0)
      Pending
      @elseif($tag->status == 1)
      Accepted 
      @elseif($tag->status == 2)
      Declined 
      @else 
      Cancelled 
      @endif
    </td>
    <td>

    @if($tag->status == 0)
    <div style="width: 50%;">
            <form action="{{ route('accept', $tag->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button">Accept</button>
            </form>

            <form action="{{ route('decline', $tag->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-danger" role="button">Decline</button>
            </form>
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$tag->id}}"
            data-action="{{ route('tags.destroy', $tag->id) }}">Delete</a>
    </div>
        
        
       

    @else
    <div style="width: 50%">
            <form action="{{ route('changeStatus', $tag->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button" disabled>Accept</button>
            </form>

            <form action="{{ route('changeStatus2', $tag->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-danger" role="button" disabled>Decline</button>
            </form>
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$tag->id}}"
            data-action="{{ route('tags.destroy', $tag->id) }}" disabled>Delete</a>
    </div>  
    @endif
  
    </td>
  </tr>
  </tbody>
  <!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal_{{$tag->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete request for {{$tag->book_title}}?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
      </div>
    </div>
@empty
  <li class="list-group-item list-group-item-danger">Entry not found</li>  
@endforelse


@elseif($user->type == 'department representative')

@forelse($tags as $tag)
@if($tag->user_id == $user->id)

  <tr align="center">
  <td>{{$tag->department}}</td>
        <td>{{$tag->book_barcode}}</td>
        <td>{{$tag->suggest_book_subject}}</td>
    <td>
      @foreach($users as $user)
      @if($user->id == $tag->user_id)
      {{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}
      @endif
      @endforeach
    </td>
    <td> 
      @if($tag->type == 'technician librarian')
      Technician Librarian
      @elseif($tag->type == 'staff librarian')
      Staff Librarian
      @elseif($tag->type == 'department representative')
      Department Representative
      @endif
    </td>
    <td>{{$tag->department}}</td>
    <td>@if($tag->status == 0)
      Pending
      @elseif($tag->status == 1)
      Accepted 
      @elseif($tag->status == 2)
      Declined 
      @else 
      Cancelled 
      @endif</td>
    <td>
      
      <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$tag->id}}"
      data-action="{{ route('tags.destroy', $tag->id) }}">Delete</a></td>
  </tr>
@endif
  <!-- Delete User Modal -->
  <div class="modal fade" id="deleteUserModal_{{$tag->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete request for {{$tag->book_title}}?
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        </div>
      </div>
    </div>
@empty
  <li class="list-group-item list-group-item-danger">Entry not found</li>  
@endforelse
@endif
  


</table>
<div class="d-flex">
    <div class="mx-auto">
      <?php echo $tags->render(); ?>
    </div>
</div>




@endsection