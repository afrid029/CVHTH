<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="Assets/CSS/NavBar.css">
</head>

<body>

    <nav class="navbar">
        <div class="logo">
            <a href="/">CVHTH</a>
        </div>
        <ul class="nav-links">
            <?php 
                // SESSION_START();
                if(isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'superadmin')){
                    echo "<li  ><a class='nav-donation' href='/donation'>Donations</a></li>";
                }

                if(isset($_SESSION['role']) && ($_SESSION['role'] === 'superadmin' || $_SESSION['role'] === 'admin')){
                    echo " <li ><a class='nav-users' href='/users'>Users</a></li>";
                    echo " <li><a  class='nav-bene' href='/beneficent'>Beneficiaries</a></li>";
                }

                if(isset($_SESSION['role']) && $_SESSION['role'] !== 'donor'){
                    echo "<li ><a class='nav-sentdon' href='/sentdonation'>Disbursed</a></li>";
                    echo "  <li ><a class='nav-projects' href='/project'>Projects</a></li>";
                }


            ?>
            
            <li onclick="logout()" id="active" class = 'logout'><a >Logout</a></li>
            <li style="display: none;" id="non-active" class = 'logout'><a >Loging Out..</a></li>
        </ul>
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </nav>

    <script>
        const mobileMenu = document.getElementById('mobile-menu');
        const navLinks = document.querySelector('.nav-links');

        mobileMenu.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        function logout(){
            //document.cookie = 'user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            const button1 = document.getElementById('active');
            const button2 = document.getElementById('non-active');
            button1.style.display = 'none';
            button2.style.display = 'block';

            window.location.href = '/logout';
            
          
        }
    </script>
</body>

</html>