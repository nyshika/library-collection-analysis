@extends('master_layout.master')
@section('Title', 'Books')
@section('content')
<h2 style="text-align: center;">Books</h2>

<div>
<form style="margin:auto;max-width:300px">
    <input type="search" class="form-control mr-sm-2" placeholder="Search Books" name="search"  value="{{ request('search') }}">
    <input class="btn btn-primary my-2 my-sm-0" type="submit" value="Search">
</form>
</div>

@if($user->type == 'technician librarian')
<a class="btn btn-primary" href="{{ route('books.create') }}" >Add Book</a>

<table class="table table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>Book Title</th>
    <th>Author</th>
    <th>Copyright Year</th>
    <th>Sublocation</th>
    <th>Tags</th>
    <th>Actions</th>
  </tr>
</thead>
@forelse($books as $book)
<tbody>
  <tr align="center">
    <td>{{$book->book_title}}</td>
    <td>{{$book->book_author}}</td>
    <td>{{$book->book_copyrightyear}}</td>
    <td>{{$book->book_sublocation}}</td>
    <td><?php $t = $book->book_subject;
            $a = explode(" ", $t );
            echo implode(", ", $a ); ?>

    </td>
    <td><a class="btn btn-primary" href="{{ route('books.edit', $book->id) }}" role="button">Edit</a>
        <a data-toggle="modal" class="btn btn-danger" data-target="#deleteUserModal_{{$book->id}}"
              data-action="{{ route('books.destroy', $book->id) }}">Delete</a>
    </td>
  </tr>
  </tbody>

<!-- Delete Modal -->
<div class="modal fade" id="deleteUserModal_{{$book->id}}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Are you sure you want to delete this book?.</h5>
          </div>
          <form action="{{ route('books.destroy', $book->id) }}" method="POST">
            <div class="modal-body">
              @csrf
              @method('DELETE')
              <h5 class="text-center">Delete {{$book->book_title}} ?
               
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
<table class="table table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
  <th>Book Title</th>
    <th>Author</th>
    <th>Copyright Year</th>
    <th>Sublocation</th>
    <th>Subjects</th>
    <th>Actions</th>
  </tr>
</thead>
@forelse($books as $book)
<tbody>
  <tr align="center">
  <td>{{$book->book_title}}</td>
    <td>{{$book->book_barcode}}</td>
    <td>{{$book->book_author}}</td>
    <td>{{$book->book_copyrightyear}}</td>
    <td>{{$book->book_sublocation}}</td>
    <td><?php $t = $book->book_subject;
            $a = explode(" ", $t );
            echo implode(", ", $a ); ?>
    </td>
    <td><a class="btn btn-primary" href="{{ route('tags.create', ['book_barcode' => $book->book_barcode]) }}" role="button">Suggest Subject</a></td>

    
  </tr>
  </tbody>
@empty
<li class="list-group-item list-group-item-danger">Entry not found</li> 
@endforelse

@elseif($user->type == 'staff librarian')
<table class="table table-bordered" style="width:100%">
<thead class="thead-dark">
  <tr align="center">
    <th>Book Title</th>
    <th>Author</th>
    <th>Copyright Year</th>
    <th>Sublocation</th>
    <th>Tags</th>
    <th>Actions</th>
  </tr>
</thead>
@forelse($books as $book)
<tbody>
  <tr align="center">
    <td>{{$book->book_title}}</td>
    <td>{{$book->book_barcode}}</td>
    <td>{{$book->book_author}}</td>
    <td>{{$book->book_copyrightyear}}</td>
    <td>{{$book->book_sublocation}}</td>
    <td><?php $t = $book->book_subject;
            $a = explode(" ", $t );
            echo implode(", ", $a ); ?>
    </td>
    </td>
  </tr>
  </tbody>
@empty
<li class="list-group-item list-group-item-danger">Entry not found</li> 
@endforelse

@endif

</table>
<div class="d-flex">
    <div class="mx-auto">
      <?php echo $books->render(); ?>
    </div>
</div>

<br>
<a class="btn btn-primary" href="{{ route('createPDFBook') }}" target=”_blank”>Export to PDF</a>
@endsection