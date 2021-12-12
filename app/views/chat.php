<?=$header??""?>
<div class="row g-5">
    <div>

        <div class="chat_window">
            <div class="top_menu">
                <div class="buttons">
                    <div class="button close"></div>
                    <div class="button minimize"></div>
                    <div class="button maximize"></div>
                </div>
                <div class="title">Chat ( <?= $_SESSION["user"]["email"] ?>)</div>
            </div>
            <ul id="chat_history" class="messages">


            </ul>
            <div class="bottom_wrapper clearfix">
                <form method="post" action="/chat">
                    <div class="message_input_wrapper">

                        <input id="mess_text" autofocus multiple name="message" type="text" class="message_input" placeholder="Type your message here...">

                    </div>
                    <input class="send_message" value="Send" type="submit">
                    <div class="error"><?=$error??""?></div>
            </div>

            </>

        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script >
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


    </script>
</div>
