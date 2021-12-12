$(document).ready(function() {

    let elem = $("#chat_history");
    // setInterval(loadFromServer, 5000)
    Send();

    function loadFromServer() {
        $.get("/history", function(data) {

            elem.html(data)
        });
    }

    function Send() {
        $.get("/history", function(data) {
            elem.html(data)
            $(elem).scrollTop($(elem)[0].scrollHeight);
        });
    }

    $("form").submit(function(event) {

        event.preventDefault();

        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            dataType: "html",
            contentType: false,
            cache: false,
            processData: false,

            beforeSend: function() {
                $(".send_message").prop("disabled", true);
            },

            success: function() {
                $(".send_message").prop("disabled", false);
                $("form").trigger("reset");
                Send();
            }
        })
    })
})
