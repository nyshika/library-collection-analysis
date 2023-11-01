@extends('master_layout.master')
@section('Title', 'Book Subject')
@section('content')

<h2 style="text-align: center;">Books Subject</h2>

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

<a class="btn btn-primary my-2 my-sm-0" href="{{ route('subjects.index') }}">Back to list</a>

<table class="table table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>Department</th>
    <th>Book Barcode</th>
    <th>Suggested Tags</th>
    <th>Actions</th>
  </tr>
</thead>

@forelse($pending as $pendingt)
<tbody>
  <tr align="center">
    <td>{{$pendingt->id}}</td>
    <td>{{$pendingt->department}}</td>
    <td>{{$pendingt->book_barcode}}</td>
    <td>{{$pendingt->suggest_book_subject}}</td>

    <td>
      @if($pendingt->type == 'technician librarian')
      Technician Librarian
      @elseif($pendingt->type == 'staff librarian')
      Staff Librarian
      @elseif($pendingt->type == 'department representative')
      Department Representative
      @endif
    </td>
    <td>{{$pendingt->department}}</td>
    <td>
    @if($pendingt->status == 0)
     Pending
    @endif
    </td>
    <td>

    @if($pendingt->status == 0)
    <div style="width: 50%;">
            <form action="{{ route('accept', $pendingt->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button">Accept</button>
            </form>

            <form action="{{ route('decline', $pendingt->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-danger" role="button">Decline</button>
            </form>
            <!-- <a class="btn btn-primary" href="{{ route('tags.edit', $pendingt->id) }}" role="button">Edit</a> -->
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$pendingt->id}}"
            data-action="{{ route('tags.destroy', $pendingt->id) }}">Delete</a>
    </div>
        
      
    @else
    <div style="width: 50%">
            <form action="{{ route('accept', $pendingt->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-success" role="button" disabled>Accept</button>
            </form>

            <form action="{{ route('decline', $pendingt->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('GET') }}
                <button type="submit" class="btn btn-danger" role="button" disabled>Decline</button>
            </form>
            <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$pendingt->id}}"
            data-action="{{ route('tags.destroy', $pendingt->id) }}" disabled>Delete</a>
    </div>  

  
    </td>
  </tr>
  </tbody>
  <!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal_{{$pendingt->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this request?</h5>
            
          </div>
          <form action="{{ route('tags.destroy', $pendingt->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete request for {{$pendingt->book_title}}?
               
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
  <li class="list-group-item list-group-item-danger">No Pending Tags</li>  
@endforelse

</table>
<div class="d-flex">
    <div class="mx-auto">
      <?php echo $pending->render(); ?>
    </div>
</div>
@endsection