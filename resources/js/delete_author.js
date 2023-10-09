import 'jquery';
import './bootstrap';

$(document).on('click', '.remove-author', function (e) {
    e.preventDefault();
    let $btn = $(this);
    let authorId = $btn.data('route');

    $.ajax({
        url: authorId,
        type: 'DELETE',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $btn.parent().remove();
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});



