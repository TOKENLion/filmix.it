$(function(){
    $('#films').DataTable({
        serverSide: true,
        ajax: {
            "url": $('#films').data('href'),
            "type": "POST",
        },
        "order": [[ 0, "asc" ]],
        "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
        "columns": [
            { "orderable": true },
            { "orderable": true },
            { "orderable": true },
            { "orderable": false },
            { "orderable": false },
            { "orderable": true },
            { "orderable": false },
            { "orderable": false }
        ]
    });
})