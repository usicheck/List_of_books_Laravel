@if ($author)
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center" aria-current="true">
            <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#myModal_2_{{ $author->id }}">
                Відредагувати
            </button>
            <span>{{ __($author->name . ' ' . $author->surname . ' ' . $author->father_name) }}</span>


            <a data-route="{{ route('ajax.authors.delete', $author->id) }}"
               class="btn btn-danger remove-author ml-auto">x</a>
        </li>
    </ul>


    <div class="modal fade" id="myModal_2_{{ $author->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabelEdit">Відредагувати дані автора</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editAuthorForm_{{ $author->id }}" enctype="multipart/form-data"
                          action="{{ route('authors.update', $author->id) }}" data-id="{{ $author->id }}" method="POST">
                        @csrf
                        @method('PUT')


                        <div class="form-group">
                            <label for="name">Ім'я:</label>
                            <input type="text" class="form-control" id="edit_name_{{ $author->id }}" name="name"
                                   value="{{$author->name}}" required>
                        </div>

                        <div class="form-group">
                            <label for="surname">Прізвище:</label>
                            <input type="text" class="form-control" id="edit_surname_{{ $author->id }}" name="surname"
                                   value="{{$author->surname}}" required>
                        </div>

                        <div class="form-group">
                            <label for="father_name">По-батькові:</label>
                            <input type="text" class="form-control" id="edit_father_name_{{ $author->id }}"
                                   name="father_name" value="{{$author->father_name}}">
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                        <button type="submit" class="btn btn-light" id="saveEditAuthor"
                                data-author-id="{{ $author->id }}">Зберегти
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endif

