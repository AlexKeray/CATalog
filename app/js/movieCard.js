function handleDeleteMedia() {
    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        const $btn = $(this);

        if (confirm('Сигурен ли си, че искаш да изтриеш този елемент?')) {
            $.ajax({
                url: `/delete`,
                method: 'POST', // или 'DELETE' според сървърната логика
                data: { id: id }, // ако е нужно
                success: function () {
                    // Премахни родителския елемент, напр. цялата карта/ред
                    $btn.closest('.media-item').remove();
                },
                error: function () {
                    alert('Грешка при изтриване.');
                }
            });
        }
    });
}