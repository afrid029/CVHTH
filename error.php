<html>
    <head>

    <title>CVHTH | Not Found</title>
    <link rel="icon" type="image/png" href="Assets/Images/cv.png" />

    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh;
            color: #23b2ef;
            border: 5px solid orange;
            border-radius: 16px;
            margin: auto;
            width: 90%;
            flex-direction: column;
        }
    </style>

    </head>

    <body style="height: 100%; display: flex; width:100%;">
        <div class="container">
            <h1> <span style="color: #2596be">Page Not</span> <span style="color: #f58f40">Found</span> </h1>
            <span style="font-size: 100px; margin-top: -50px;
">&#128758;</span>

            <h5>Redirecting to Home Page... (If not <a href="/">Click here</a>)</h5>
        </div>

        <script>
            window.onload = function() {
                setTimeout(()=>{
                    // console.log('leaav');
                    
                    window.location.pathname = "/"
                }, 3000)
            }
        </script>
    </body>
</html>