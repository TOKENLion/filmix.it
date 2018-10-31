$(function(){
    $('#actors').DataTable({
        serverSide: true,
        ajax: {
            "url": $('#actors').data('href'),
            "type": "POST",
        },
        "order": [[ 0, "asc" ]],
        "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
        "columns": [
            { "orderable": true },
            { "orderable": false },
            { "orderable": true },
            { "orderable": true },
            { "orderable": false }
        ]
    });
})