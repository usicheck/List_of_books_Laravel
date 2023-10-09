@extends('layouts.app')

@section('content')

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Додати автора
    </button>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Додати автора</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addAuthorForm" enctype="multipart/form-data" action="{{ route('authors.store') }} "
                          method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Ім'я:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="surname">Прізвище:</label>
                            <input type="text" class="form-control" id="surname" name="surname" required>
                        </div>

                        <div class="form-group">
                            <label for="father_name">По-батькові:</label>
                            <input type="text" class="form-control" id="father_name" name="father_name">
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                        <button type="submit" class="btn btn-primary" id="saveAuthor">Зберегти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <form action="{{ route('authors.index') }}" method="GET">
                <div class="input-group">
                    <select class="form-select" name="sort_by">
                        <option value="surname" @if(request('sort_by') == 'surname') selected @endif>Surname</option>
                        <option value="random" @if(request('sort_by') == 'random') selected @endif>Random</option>
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">Sort</button>
                </div>
            </form>
            <form class="d-flex" action="{{ route('authors.index') }}" method="GET" role="search">
                <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search"
                       value="{{ request('search') }}">
                <button class="btn btn-outline-success me-2" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <div class="container">
        <h1 class="text-center">Список Авторів</h1>

        <ul id="list-base">
            @each('authors.parts.author_view', $authors, 'author')

        </ul>


        <ul class="pagination">
            @if ($authors->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $authors->previousPageUrl() }}">Previous</a></li>
            @endif

            @foreach ($authors->getUrlRange(1, $authors->lastPage()) as $page => $url)
                @if ($page == $authors->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($authors->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $authors->nextPageUrl() }}">Next</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </div>

@endsection

@push('footer-scripts')
    @vite(['resources/js/modal_create_author.js','resources/js/modal_update_author.js','resources/js/delete_author.js'])
@endpush

