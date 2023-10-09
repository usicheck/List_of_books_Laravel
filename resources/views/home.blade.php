@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Home page') }}</div>
                    <div class="col-md-12">
                        <div class="album py-5 bg-light">
                            <div class="container">
                                <div class="row">
                                    @each('books.parts.book_view', $books, 'book')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


