@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3 class="text-center">{{ __($book->title) }}</h3>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <img src="{{asset($book->image)}}" class="card-img-top"
                 style="width: 50%;  margin: 0 auto; display: block;">
        </div>
        <div class="col-md-6">
            <hr>
            <div>
                <p>Автор(-и) книг:
                    @foreach ($book->authors as $author)
                        {{ $author->surname . ' ' . $author->name . ' ' . $author->father_name }}
                        @if (!$loop->last), @endif
                @endforeach
            </div>
            <hr>
            <form action="{{ route('books.delete', $book->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" class="btn btn-danger" value="Видалити">
            </form>

            <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#myModalBookEdit_{{ $book->id }}">
                Відредагувати
            </button>


            <div class="modal fade" id="myModalBookEdit_{{ $book->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Відредагувати книгу</h4>
                        </div>
                        <div class="modal-body">
                            <form id="editBookForm" enctype="multipart/form-data"
                                  action="{{ route('books.update',$book->id) }} " method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="title">Назва книги:</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{$book->title}}" required>
                                </div>

                                <div class="form-group">
                                    <label for="short_des">Короткий опис:</label>
                                    <input type="text" class="form-control" id="short_des" name="short_des"
                                           value="{{$book->short_des}}" required maxlength="2500">
                                </div>

                                <div class="form-group">
                                    <label for="image">Зображення:</label>
                                    <input type="file" class="form-control-file" id="image" name="image"
                                           accept="image/jpeg,image/png" >
                                </div>

                                <div class="form-group">
                                    <label for="publication_date">Дата публікації:</label>
                                    <input type="date" class="form-control" id="publication_date"
                                           name="publication_date" value="{{$book->publication_date}}" required>
                                </div>

                                <div class="form-group">
                                    @php
                                        $selectedAuthors = $book->authors->pluck('id')->toArray();
                                    @endphp
                                    <label for="authors">Автори:</label>
                                    @foreach($authors as $author)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                   id="author_{{ $author->id }}" name="authors[]"
                                                   value="{{ $author->id }}" {{ in_array($author->id, $selectedAuthors) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="author_{{ $author->id }}">{{ $author->name }} {{ $author->surname }}</label>
                                        </div>
                                    @endforeach
                                </div>


                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                                <button type="submit" class="btn btn-primary" id="saveBook">Зберегти</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row-fluid">
            <div class="col-md-10 text-left">
                <h4>Description: </h4>
                <p>{{ $book->short_des }}</p>
            </div>
        </div>
        <hr>
        @endsection
        @push('footer-scripts')
            @vite(['resources/js/validate_update_book.js'])
    @endpush
