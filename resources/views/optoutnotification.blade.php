<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
        <title> Opt out to receive notification </title>
    </head>
    <body>
        <div class='' style="width: 40%;margin: 10px auto;">
            <center>
                <div class='card pd-10'>
                    <?php if ($action == "deactivate") { ?>
                        <h3> Success </h3>
                        <p> You will not be recieving any notifications for this item. </p>

                        <a href='#'> Reactivate </a>
                    <?php } else {?>
                        <h3> GREAT!!! </h3>
                        <p> You will now be receiving notifications for this item. </p>

                        <a href='#'> Deactivate </a>
                    <?php } ?>
                </div>
            </center>
        </div>
    </body>
</html>
