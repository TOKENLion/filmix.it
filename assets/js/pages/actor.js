$(function(){
    $('#button-search-actors').on('click', function () {
        let btn = $(this),
            inputSearch = $("input[name='search']");

        $.ajax({
            method: 'POST',
            dataType: 'JSON',
            url: btn.data('href'),
            data: { search: inputSearch.val()},
            success: function (response) {
                removeLoader();
                if (response.status === 'success' && typeof response.content != "undefined") {
                    $("#table-actors-rows").html(response.content);
                } else {
                    toastr[response.status](response.message);
                }
            },
            beforeSend: function () {
                loader($(".table-hover").closest("div"));
            },
            error: function () {
                toastr['warning']('Please try again later!');
                removeLoader();
            }
        });
    })
})