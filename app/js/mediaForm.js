$(function () {
    handleToggleEpisodesInput();
    handleToggleNewGenreInput();

    $('#type-select').trigger('change');
    $('#genre-select').trigger('change');
});

function handleToggleEpisodesInput() {
    $('#type-select').on('change', function () {
        const selected = $(this).find("option:selected").text().toLowerCase();
        if (selected === 'сериал') {
            $('#episodes-wrapper').slideDown(150);
        } else {
            $('#episodes-wrapper').slideUp(150);
            $('#episodes_count').val('');
        }
    });
}

document.getElementById('image').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
});