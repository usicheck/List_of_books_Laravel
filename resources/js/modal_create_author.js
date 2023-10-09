import 'jquery';
import './bootstrap';

$(document).ready(function () {
    $('#addAuthorForm').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var url = '/authors/store/';

        var nameField = form.find('#name');
        var surnameField = form.find('#surname');
        var fatherNameField = form.find('#father_name');

        if (nameField.val().length < 1 || nameField.val().length > 100) {
            alert('Довжина імені повинна бути в межах 1-100 символів');
            return;
        }
        if (surnameField.val().length < 3 || surnameField.val().length > 100) {
            alert('Довжина прізвища повинна бути в межах 3-100 символів');
            return;
        }

        if (fatherNameField.val().length > 100) {
            alert('Довжина по-батькові повинна бути до 100 символів');
            return;
        }

        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize(),
            dataType: 'json',


            success: function (response) {


                var authorHtml = `
                <div class="list-group">
                <li class="list-group-item">
                <span>
               ${response.name} ${response.surname} ${response.father_name}
                 </span>
                 </li>
                 </div>

`;
                $('#list-base').append(authorHtml);
                form.trigger('reset');
                $('#myModal').hide();
                $('.modal-backdrop').remove();


            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});

