<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/AllDonations.css">


</head>

<body style="width: 100vw; display:contents;">
    <nav class="navbar">
        <div class="logo">
            <a href="#">MySite</a>
        </div>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </nav>

    <div class="main-body">
        <div class="main-sidebar">
            <div class="sidebar-content">

                <div class="bar-row">
                    <button class="add-btn">Add Donation</button>
                </div>
                <div class="bar-row">
                    <div class="row-type">
                        Current Balance
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <div id="current">...</div>
                    </div>
                </div>
                <hr class="line">
                <div class="bar-row">
                    <div class="row-type">
                        Donated
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <div id="spent">...</div>
                    </div>
                </div>
                <hr class="line">
                <div class="bar-row">
                    <div class="row-type">
                        Total Recieved Fund
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <div id="total">...</div>
                    </div>
                </div>
            </div>


        </div>
        <div class="main-content">

            <div class="content-title">
                <h3>All Donations</h3>
            </div>



            <div class="content-table">
                <div class="table">

                    <div class="table-header">
                        <div>Donor Name</div>
                        <div style='text-align: end'>Amount (RS)</div>
                        <div style='text-align: end'>Donated Date</div>
                        <div style='text-align: center'>Functions</div>

                    </div>


                    <div id="table-rows"></div>
                    <div id="table-pagi"></div>
                   



                </div>
            </div>

            <div id="loading-spinner" class="loading-spinner"></div>

        </div>
    </div>


    <script>
        const mobileMenu = document.getElementById('mobile-menu');
        const navLinks = document.querySelector('.nav-links');

        mobileMenu.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        const navHeight = document.querySelector('.navbar');
        const mainBody = document.querySelector('.main-body');
        // console.log(navHeight.offsetHeight);

        const navbarHeight = navHeight.offsetHeight; // Get the navbar height

        // Set the height of the main-body using calc with the navbar height
        // mainBody.style.height = `calc(100% - ${navbarHeight}px)`;
        mainBody.style.top = `${navbarHeight}px`;

        function DisplayNumber(targetNumber, ID) {
            const numberElement = document.getElementById(ID);
            let currentNumber = 0;
            const duration = 2000; // 2 seconds
            const incrementTime = 50;
            const incrementStep = targetNumber / (duration / incrementTime);
            const countUp = () => {
                currentNumber += incrementStep;
                if (currentNumber >= targetNumber) {
                    currentNumber = targetNumber;
                    clearInterval(interval); // Stop the animation
                }
                // Update the text content of the div
                numberElement.textContent = Math.round(currentNumber);
            };
            const interval = setInterval(countUp, incrementTime);
        }

        DisplayNumber(70000, 'current');
        DisplayNumber(20000, 'spent');
        DisplayNumber(90000, 'total');

        const addBtn = document.querySelector('.add-btn');
        addBtn.addEventListener('click', function() {
            console.log('clicked');

            addBtn.classList.add('clicked')

            setTimeout(() => {
                addBtn.classList.remove('clicked')
            }, 1000)
        })









        function loadPage(page) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/Controllers/GetDonations.php?page=' + page, true);
            document.getElementById('loading-spinner').style.display = 'block';

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('loading-spinner').style.display = 'none';
                    var response = JSON.parse(xhr.responseText);

                    const dataContainer = document.getElementById('table-rows')

                    dataContainer.innerHTML = response.html;

                    dataContainer.classList.remove('fade-in'); // Remove the class to reset animation
                    void dataContainer.offsetWidth; // Trigger reflow
                    dataContainer.classList.add('fade-in'); // Apply fade-in animation

                    
                    document.getElementById('table-pagi').innerHTML = response.pagination;
                }
            };

            xhr.send();
        }

        // Load the first page initially
        window.onload = function() {
            loadPage(1);
        };
    </script>

</body>

</html>