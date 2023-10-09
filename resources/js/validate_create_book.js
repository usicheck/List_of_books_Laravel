import 'jquery';
import './bootstrap';

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("addBookForm");
    form.addEventListener("submit", function (event) {
        const imageField = document.getElementById("image");
        const titleField = document.getElementById("title");
        const publicationDateField = document.getElementById("publication_date");
        const authorsField = document.querySelectorAll('input[name="authors[]"]:checked');

        let isValid = true;

        if (imageField.files.length > 0) {
            const allowedExtensions = ["jpg", "png"];
            const maxFileSize = 2 * 1024 * 1024; // 2 Мб

            const imageExtension = imageField.files[0].name.split(".").pop().toLowerCase();
            if (!allowedExtensions.includes(imageExtension)) {
                alert("Дозволені розширення для зображення: jpg, png.");
                isValid = false;
            }

            if (imageField.files[0].size > maxFileSize) {
                alert("Максимальний розмір зображення - 2 Мб.");
                isValid = false;
            }
        }


        if (titleField.value.trim() === "") {
            alert("Назва книги - обов'язкове поле.");
            isValid = false;
        } else if (titleField.value.trim().length < 3) {
            alert("Назва книги має містити принаймні 3 символи.");
            isValid = false;
        }

        if (publicationDateField.value.trim() === "") {
            alert("Дата публікації - обов'язкове поле.");
            isValid = false;
        }

        if (authorsField.length === 0) {
            alert("Вибір автора є обов'язковим.");
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});
