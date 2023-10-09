<div class="col-md-4">
    <div class="card mb-4 shadow-sm">
        <img src="{{ asset($book->image) }}" class="card-img-top"
        >
        <div class="card-body">
            <p class="card-title">{{ __($book->title) }}</p>
            <hr>
            <p class="card-text">{{ __($book->short_des) }}</p>
            <hr>
            <p class="card-text">{{ __($book->publication_date) }}</p>
            <p class="card-text">Автори:
                @foreach ($book->authors as $author)
                    {{ $author->surname . ' ' . $author->name . ' ' . $author->father_name }}
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </p>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="{{ route('books.show', $book->id) }}"
                       class="btn btn-sm btn-outline-dark">
                        {{ __('Show') }}
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
