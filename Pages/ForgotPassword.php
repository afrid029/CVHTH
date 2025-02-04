<html>

<head>

    <link href="Assets/CSS/Password.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CVHTH | Forgot Password</title>
    <link rel="icon" type="image/png" href="Assets/Images/cv.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

</head>

<body>
<?php
    SESSION_START();
    if (isset($_SESSION['fromAction']) && $_SESSION['fromAction'] === true) { ?>


        <div class="alert-container" id="alert">
            <div class="alert" id="alertCont">
                <p><?php echo $_SESSION['message'] ?></p>
            </div>
        </div>

        <?php
        if ($_SESSION['status'] === true) {
            echo "<script>document.getElementById('alertCont').style.backgroundColor = '#1D7524';</script>";
        } else {
            echo "<script>document.getElementById('alertCont').style.backgroundColor = '#E44C4C';</script>";
        }
        ?>
        <script>
           setTimeout(() => {
            document.getElementById('alert').style.display = 'flex';
           }, 2000);

            setTimeout(() => {
                document.getElementById('alert').style.display = 'none';
            }, 7000);
        </script>
    <?php
    }
    $_SESSION['fromAction'] = false;
    ?>

    <div class="top-bar"></div>
    <form class="form" action="/generate-password"  method="post" onsubmit="return submitForgotform()">
        <div class="form-div">
            <h5>Forgot Password</h5>
            <div class="FormRow">
                <input type="email" name="email" id="email" required placeholder="Enter your Authenticated Email">
            </div>
            <button type="submit" name="submit" id="submit" class='btn'>Generate Password</button>

                        <button
                            style="display: none;"
                            id="submiting"
                            disabled="true"
                            class="btn"> Generating...
                        </button>


            <a href="/">Go to signin</a>
        </div>

    </form>

    <script>
         function submitForgotform() {
        let button = document.getElementById('submit');
        let button2 = document.getElementById('submiting');
        button.style.display = 'none';
        button2.style.display = 'block';
        return true;
    }
    </script>


</body>

</html>