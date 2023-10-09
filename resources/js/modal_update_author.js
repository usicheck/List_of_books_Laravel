import 'jquery';
import './bootstrap';

$(document).ready(function () {

    $(document).on("click", "#saveEditAuthor", function (e) {
        e.preventDefault();
        let form = $(this);
        let authorId = form.data('author-id');
        let url = 'authors/update/' + authorId;

        var nameFieldId = 'edit_name_' + authorId;
        var surnameFieldId = 'edit_surname_' + authorId;
        var fatherNameFieldId = 'edit_father_name_' + authorId;

        var name = $('#' + nameFieldId).val();
        var surname = $('#' + surnameFieldId).val();
        var father_name = $('#' + fatherNameFieldId).val();

        if (name.length < 1 || name.length > 100) {
            alert('Довжина імені повинна бути в межах 1-100 символів');
            return;
        }
        if (surname.length < 3 || surname.length > 100) {
            alert('Довжина прізвища повинна бути в межах 3-100 символів');
            return;
        }

        if (father_name.length > 100) {
            alert('Довжина по-батькові повинна бути до 100 символів');
            return;
        }

        $.ajax({
            url: url,
            type: 'PUT',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            data: {
                name: name,
                surname: surname,
                father_name: father_name
            },

            success: function (response) {

                var authorsHtml = '';

                $.each(response.authors, function (index, author) {
                    authorsHtml += '<li>' + author.name + ' ' + author.surname + ' ' + author.father_name + '</li>';
                });

                $('#list-base').html(authorsHtml);

                form.trigger('reset');
                $('#myModal_2_' + authorId).hide();
                $('.modal-backdrop').remove();
            },

        });
    });
});

