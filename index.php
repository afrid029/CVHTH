<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Bebas+Neue&family=DM+Serif+Text:ital@0;1&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playwrite+VN:wght@100..400&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/Home.css">
</head>

<body style="width: 100vw; display:contents">

    <div class="home-body">

        <div class="home-info" id="home-Id">
            <div class="home-bgImage">

            </div>
            <!-- <div class="home-bg">

            </div> -->

            <div class="home-content">
                
                <div class="thought">
                <div onclick="openLogin('flex')" id="loginToggle" class="loginMobile">
                    <img src="./Assets/Images/user.png" alt=""> Login
                </div>
                    <div class="thought-text">
                        <span style="background-color: #2F41E4; padding: 5px; border-radius: 5px; margin-right: 5px;">Love and charity </span> for the whole human race, that is the test of true religiousness.
                    </div>
                    <div class="thought-author">
                        -Swami Vivekananda-
                    </div>

                </div>

                <div class="title">
                    <div class="title-bg"></div>
                    <div id="title" class="title-footer">Chulipuram Vasantham Helping The Helpless - CVHTH</div>
                    <!-- <div class="txt txt1"></div> -->
                </div>
            </div>

            <div class="about scroll-element">
                <div class="about-title">Who We Are...</div>


                <div class="about-content">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vehicula turpis ut risus cursus, ac tincidunt nulla ultricies. Mauris sollicitudin, felis ut tincidunt interdum, sapien felis consectetur purus, a feugiat ipsum nulla id arcu. Nullam varius, felis non posuere tincidunt, eros ligula dictum erat, in congue lectus eros a ante.


                </div>
            </div>
            <div class="about scroll-element">
                <div class="about-title">Mission</div>


                <div class="about-content">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vehicula turpis ut risus cursus, ac tincidunt nulla ultricies. Mauris sollicitudin, felis ut tincidunt interdum, sapien felis consectetur purus, a feugiat ipsum nulla id arcu. Nullam varius, felis non posuere tincidunt, eros ligula dictum erat, in congue lectus eros a ante.

                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vehicula turpis ut risus cursus, ac tincidunt nulla ultricies. Mauris sollicitudin, felis ut tincidunt interdum, sapien felis consectetur purus, a feugiat ipsum nulla id arcu. Nullam varius, felis non posuere tincidunt, eros ligula dictum erat, in congue lectus eros a ante.

                </div>
            </div>
            <div class="about scroll-element">
                <div class="about-title">Vision</div>


                <div class="about-content">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vehicula turpis ut risus cursus, ac tincidunt nulla ultricies. Mauris sollicitudin, felis ut tincidunt interdum, sapien felis consectetur purus, a feugiat ipsum nulla id arcu. Nullam varius, felis non posuere tincidunt, eros ligula dictum erat, in congue lectus eros a ante.

                </div>
            </div>


        </div>
        <div class="home-login mobile-login" id="home-login">
            <div class="loginbg"></div>

            <div onclick="openLogin('none')" class="loginMobile" style="color: black;">
                    <img src="./Assets/Images/close.png" style="width: 32px;"> Close
                </div>

            <div class="login-title">
                <h3>Welcome to <span style="color: #2F41E4;">CVHTH</span></h3>
                <h4>Login</h4>
            </div>

            <form class="login-form" action="#" method="post">
                <div class="FormRow">
                    <input type="text" id="email" name="email" required placeholder="Enter Your Username or Email">
                </div>
                <div class="FormRow">
                    <input type="password" id="password" name="password" required placeholder="Enter Your Password">
                </div>
                <div class="FormRow">
                    <button type="submit" name="login" class="btn-login">Login</button>
                </div>
            </form>
            <div class="forgot-btn">
                Forgot Password?
            </div>



        </div>
    </div>

    <!-- <div class="content">
  <div class="scroll-element">Content 1</div>
  <div class="scroll-element">Content 2</div>
  <div class="scroll-element">Content 3</div>
  <div class="scroll-element">Content 4</div>
</div> -->

    <script>
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target); // Stop observing after the animation is triggered
                }
            });
        }, {
            threshold: 0.2
        }); // 50% of the element needs to be visible for the animation to trigger

        // Observe all elements with the class '.about-title'
        const elements = document.querySelectorAll('.about');
        elements.forEach(element => {
            observer.observe(element);
        });


        const title = document.getElementById('title');
        const contentText = title.textContent;
        title.textContent = ''

        contentText.split('').forEach((letter, index) => {
            const span = document.createElement('span');
            if (letter == ' ') {
                span.innerHTML = '&nbsp';
            } else {
                span.textContent = letter;
            }

            span.style.animationDelay = `${index * 0.1}s`;
            title.appendChild(span);

        });

        function openLogin(value){
            const loginSide = document.getElementById('home-login');
           
            // console.log(loginSide);
            

            if(value === 'flex'){
                
                loginSide.classList.add('mobile-login')
                loginSide.classList.remove('mobile-login-fade')
                loginSide.style.display=value;
                    document.getElementById('loginToggle').style.display='none';

                // setTimeout(() => {
                    
                // }, 100);
            }else {
                
                loginSide.classList.remove('mobile-login')
                loginSide.classList.add('mobile-login-fade')
                
                setTimeout(() => {
                    loginSide.style.display=value;
                document.getElementById('loginToggle').style.display='flex'

                }, 100);
            }
        }



        // Get all elements with the 'scroll-element' class
    </script>

</body>

</html>