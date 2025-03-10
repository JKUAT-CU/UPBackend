function loadPage(page) {
    $.ajax({
        url: "pages/" + page + ".php",
        method: "GET",
        success: function (data) {
            $('#content-area').html(data);
        },
        error: function () {
            $('#content-area').html('<p>Error loading page.</p>');
        }
    });
}
