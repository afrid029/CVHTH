<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="Assets/CSS/NavBar.css">
</head>

<body>

    <nav class="navbar">
        <div class="logo">
            <a href="#">CVHTH</a>
        </div>
        <ul class="nav-links">
            <li ><a href="/donation">Donations</a></li>
            <li><a href="/users">Users</a></li>
            <li><a href="/beneficent">Beneficiaries</a></li>
            <li><a href="/sentdonation">Sent Donations</a></li>
            <li><a href="/project">Projects</a></li>
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
    </script>
</body>

</html>