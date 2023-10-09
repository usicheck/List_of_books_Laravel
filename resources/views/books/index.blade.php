@extends('layouts.app')

@section('content')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalBook">
        Додати книгу
    </button>

    <div class="modal fade" id="myModalBook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Додати книгу</h4>
                </div>
                <div class="modal-body">
                    <form id="addBookForm" enctype="multipart/form-data" action="{{ route('books.store') }} "
                          method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="title">Назва книги:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="short_des">Короткий опис:</label>
                            <input type="text" class="form-control" id="short_des" name="short_des" maxlength="2500">
                        </div>

                        <div class="form-group">
                            <label for="image">Зображення:</label>
                            <input type="file" class="form-control-file" id="image" name="image"
                                   accept="image/jpeg,image/png" required>
                        </div>

                        <div class="form-group">
                            <label for="publication_date">Дата публікації:</label>
                            <input type="date" class="form-control" id="publication_date" name="publication_date"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="authors">Автори:</label>
                            @foreach($authors as $author)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="author_{{ $author->id }}"
                                           name="authors[]" value="{{ $author->id }}">
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



    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">

            <form action="{{ route('books.index') }}" method="GET">
                <div class="input-group">
                    <select class="form-select" name="sort_by">
                        <option value="title" @if(request('sort_by') == 'title') selected @endif>Title</option>
                        <option value="random" @if(request('sort_by') == 'random') selected @endif>Random</option>
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">Sort</button>
                </div>
            </form>
            <form class="d-flex" action="{{ route('books.index') }}" method="GET" role="search">
                <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search"
                       value="{{ request('search') }}">
                <button class="btn btn-outline-success me-2" type="submit">Search</button>
            </form>
        </div>
    </nav>



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="text-center">{{ __('Всі книги') }}</h1>
            </div>
            <div class="col-md-12">
                <div class="album py-5 bg-light">
                    <div class="container">
                        <div class="row" id="book-raw">
                            @each('books.parts.book_view', $books, 'book')
                        </div>

                    </div>
                </div>
            </div>
            <div>
                <ul class="pagination">
                    @if ($books->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $books->previousPageUrl() }}">Previous</a>
                        </li>
                    @endif

                    @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                        @if ($page == $books->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    @if ($books->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $books->nextPageUrl() }}">Next</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection


@push('footer-scripts')
    @vite(['resources/js/validate_create_book.js'])
@endpush

