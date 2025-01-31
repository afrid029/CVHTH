<html>
    <head>

        <link href="Assets/CSS/Password.css" rel="stylesheet"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CVHTH | Forgot Password</title>
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    </head>

    <body>

    <?php SESSION_START(); 

    if(!isset($_SESSION['email'])){
        header('Location: /');
    }

    ?>
        
        <div class="top-bar"></div>
        <form class="form" action="/reset" method="post" oninput="validateForm()" onsubmit="return submitForgotform()">
            <div class="form-div">
                <h5>Reset Password</h5>
                <div class="FormRow">
                    <input type="email" name="email" id="email" required readonly>
                </div>
                <div class="FormRow">
                    <input type="password" id="current" name="current" required placeholder="Current Password" >
                </div>
                <div class="FormRow">
                    <input type="password" id="new" name="new" required placeholder="New Password" minlength="8" >
                </div>
                <div class="FormRow">
                    <input type="password" id="re" name="re" required placeholder="Re-type new password" minlength="8">
                </div>
                <button disabled id="submit" name="submit" class='btn'>Reset Password</button> 
                <button
                            style="display: none;"
                            id="submiting"
                            disabled="true"
                            class="btn"> Resetting...
                        </button>
                <a href="/">Go to signin</a>  
            </div>
                  
        </form>

        <script>
            document.getElementById('email').value = '<?php echo $_SESSION['email']; ?>';
        

            function validateForm() {

                let current = document.getElementById('current').value;
                let newPass = document.getElementById('new').value;
                let re = document.getElementById('re').value;
                let button = document.getElementById('submit');
                let email = document.getElementById('email').value;

                // console.log(email);
                
                // console.log(current.length > 0 && newPass.length > 0 && re.length > 0);
                

                if(current.length > 0 && newPass.length > 0 && re.length > 0){
                    if(newPass === re){
                        button.disabled = false;
                    }else {
                        button.disabled = true;
                    }
                }else {
                    button.disabled = true;
                }

            }

            function submitForgotform() {
                let button = document.getElementById('submit');
                let button2 = document.getElementById('submiting');
                button.style.display = 'none';
                button2.style.display = 'block';
                return true;
            }
   

            
        </script>

        <?php
            unset($_SESSION['email']);
        ?>
        
    </body>
</html>