<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/AllUsers.css">


</head>

<body style="width: 100vw; display:contents;">

    <?php include('../Components/NavBar.php') ?>


    <div class="main-body">
        <div class="main-sidebar">
            <div class="sidebar-content">

                <div class="bar-row">
                    <button class="add-btn">Add User</button>
                </div>
                <div class="bar-row">
                    <div class="row-type">
                        Super Admin
                    </div>
                    <div class="row-value">
                        <div>Count</div>
                        <div id="superadmin">01</div>
                    </div>
                </div>
                <div class="bar-row">
                    <div class="row-type">
                        Admins
                    </div>
                    <div class="row-value">
                        <div>Count</div>
                        <div id="admin">...</div>
                    </div>
                </div>
                <hr class="line">
                <div class="bar-row">
                    <div class="row-type">
                        Project Managers
                    </div>
                    <div class="row-value">
                        <div>Count</div>
                        <div id="prjmgr">...</div>
                    </div>
                </div>
                <hr class="line">
                <div class="bar-row">
                    <div class="row-type">
                        Donors
                    </div>
                    <div class="row-value">
                        <div>Count</div>
                        <div id="donor">

                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="main-content main-content-mobile">
            <div>
                <div class="main-conent-mobile-bg"></div>

                <div class="content-title mobile-ani">
                    <h3>Admins</h3>
                </div>



                <div class="content-table mobile-ani">
                    <div class="table">


                        <div class="table-header admin-header">
                            <div>Name</div>
                            <div >Email</div>
                            <div style='text-align: end'>Contact No.</div>
                            <div style='text-align: end'>DOB</div>
                            <div style='text-align: center'>Functions</div>

                        </div>

                        <div id="onrowload-admin"></div>
                        <div id="table-rows-admin"></div>
                        <div id="table-pagi-admin"></div>

                    </div>
                </div>

                <div id="loading-spinner-admin" class="loading-spinner"></div>
            </div>

            <div>
                <div class="main-conent-mobile-bg"></div>

                <div class="content-title mobile-ani">
                    <h3>All Donations</h3>
                </div>



                <div class="content-table mobile-ani">
                    <div class="table">


                        <div class="table-header">
                            <div>Donor Name</div>
                            <div style='text-align: end'>Amount (RS)</div>
                            <div style='text-align: end'>Donated Date</div>
                            <div style='text-align: center'>Functions</div>

                        </div>

                        <div id="onrowload"></div>
                        <div id="table-rows"></div>
                        <div id="table-pagi"></div>




                    </div>
                </div>

                <div id="loading-spinner" class="loading-spinner"></div>
            </div>

            <div>
                <div class="main-conent-mobile-bg"></div>

                <div class="content-title mobile-ani">
                    <h3>All Donations</h3>
                </div>



                <div class="content-table mobile-ani">
                    <div class="table">


                        <div class="table-header">
                            <div>Donor Name</div>
                            <div style='text-align: end'>Amount (RS)</div>
                            <div style='text-align: end'>Donated Date</div>
                            <div style='text-align: center'>Functions</div>

                        </div>

                        <div id="onrowload"></div>
                        <div id="table-rows"></div>
                        <div id="table-pagi"></div>




                    </div>
                </div>

                <div id="loading-spinner" class="loading-spinner"></div>
            </div>

        </div>
    </div>

    <!--     
    <footer>
        <div class="footer"></div>

    </footer> -->
    <script>
        function resizeWindow() {
            console.log('resizing');

            const navHeight = document.querySelector('.navbar');
            const mainBody = document.querySelector('.main-body');
            const mainSideBar = document.querySelector('.main-sidebar');
            const mainConetntMobile = document.querySelector('.main-content-mobile');
            const mainConetntMobileBg = document.querySelector('.main-conent-mobile-bg');
            const navbarHeight = navHeight.offsetHeight;
            const sideBarHeight = mainSideBar.offsetHeight;

            const viewportWidth = window.innerWidth;

            if (viewportWidth < 900) {
                
                mainConetntMobileBg.style.height = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;
                mainConetntMobile.style.height = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;

            }

            mainBody.style.top = `${navbarHeight}px`;
            // contentTitle.style.top = `${navbarHeight}px`;
            // mainConetntMobile.style.height = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;
            // console.log(mainConetntMobile.style.height,navbarHeight, sideBarHeight);
        }

        resizeWindow();

    
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

        DisplayNumber(5, 'admin');
        DisplayNumber(10, 'prjmgr');
        DisplayNumber(25, 'donor');
        // DisplayNumber(90000, 'total');


        function adminsload(page) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/Controllers/GetDonations.php?page=' + page, true);
            document.getElementById('loading-spinner-admin').style.display = 'block';
            const onload = document.getElementById('onrowload-admin');
            onload.classList.add('onrowload-admin');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('loading-spinner-admin').style.display = 'none';
                    // document.getElementById('onrowload').style.display = 'none';
                    onload.classList.remove('onrowload');
                    var response = JSON.parse(xhr.responseText);

                    const dataContainer = document.getElementById('table-rows-admin')

                    dataContainer.innerHTML = response.html;
                    // resizeWindow();

                    dataContainer.classList.remove('fade-in'); // Remove the class to reset animation
                    void dataContainer.offsetWidth; // Trigger reflow
                    dataContainer.classList.add('fade-in'); // Apply fade-in animation
                    document.getElementById('table-pagi-admin').innerHTML = response.pagination;

                    if (page === 1) {
                        // document.getElementById('admin').textContent = "From " + response.total + " donations";
                        DisplayNumber(response.total_received, 'admin')
                    }
                }
            };

            xhr.send();
        }

        // Load the first page initially
        window.onload = function() {
            adminsload(1);
        };

        window.addEventListener("resize", resizeWindow);

        
        const addBtn = document.querySelector('.add-btn');
        addBtn.addEventListener('click', function() {
            console.log('clicked');

            addBtn.classList.add('clicked')

            setTimeout(() => {
                addBtn.classList.remove('clicked')
            }, 1000)
        })
    </script>

</body>

</html>