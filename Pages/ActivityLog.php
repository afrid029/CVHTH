<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CVHTH | Donations</title>
    <link rel="stylesheet" href="Assets/CSS/ActivityLog.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>


</head>

<body style="width: 100vw; display:contents;">

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

    if (!isset($_COOKIE['user'])) {
        header('Location: /');
    } else {

        $data = base64_decode($_COOKIE['user']);

        // Extract the IV (the first 16 bytes)
        $iv = substr($data, 0, 16);

        // Extract the encrypted email (the rest of the string)
        $encryptedData = substr($data, 16);
        $key = '6f5473b5b16a3fd9576b907b2b2dcb3f07b3d59eecac4f5649356be45b5fce99811';
        // Decrypt the email using AES-256-CBC decryption
        $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);

        // $query = "SELECT * from users where email = '$decryptedEmail'";
        $passedArray = unserialize($decryptedData);
        // $result = mysqli_query($db, $query);

        if ($passedArray['role'] === 'admin' || $passedArray['role'] === 'superadmin') {
            $_SESSION['ID'] = $passedArray['ID'];
            $_SESSION['role'] = $passedArray['role'];
            $_SESSION['fname'] = $passedArray['fname'];
        } else {
            header('Location: /');
        }
    }

    include('Components/NavBar.php') ?>

    <script>
        const node = document.querySelector('.nav-activity');
        node.style.color = '#951A9C'
        node.style.fontWeight = '600'
    </script>


    <div class="main-body">
        <!-- <div class="main-sidebar">
            <div class="sidebar-content">

                <div class="bar-row">
                    <button onclick="handleAdd(true)" class="add-btn">Add Donation</button>
                </div>
                <div class="bar-row">
                    <div class="row-type">
                        Charity Balance
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <div id="current">...</div>
                    </div>
                </div>
                <hr class="line">
                <div class="bar-row">
                    <div class="row-type">
                        Disbursed Amount
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <div id="spent">...</div>
                    </div>
                </div>
                <hr class="line">
                <div class="bar-row">
                    <div class="row-type">
                        Total Recieved Donation
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <div>
                            <div style="text-align: end; margin-bottom: 10px" id="total">...</div>
                            <div style="opacity: 0.6; font-weight: 600;" id="count">From ... donations</div>
                        </div>
                    </div>
                </div>
            </div>


        </div> -->
        <div class="main-content main-content-mobile">
            <div class="main-conent-mobile-bg"></div>

            <div class="content-table mobile-ani">
                <div class="table">
                    <div class="table-header">
                        <div class="flag" style='text-align: center; '>&#128681;</div>
                        <div style='text-align: center'>Action By</div>
                        <div style='text-align: center'>Impact on</div>
                        <div style='text-align: center'>On</div>
                        <div style='text-align: center'>Old Value</div>
                        <div style='text-align: center'>New Value</div>
                        <div style='text-align: center'>Action Time</div>
                    </div>

                    <div id="onrowload"></div>
                    <div id="table-rows"></div>
                    <div id="table-pagi"></div>

                </div>


            </div>

            <div id="loading-spinner" class="loading-spinner"></div>




        </div>
    </div>


    <script>
        function resizeWindow() {
            // //console.log('resizing');

            const navHeight = document.querySelector('.navbar');
            const mainBody = document.querySelector('.main-body');
            // const mainSideBar = document.querySelector('.main-sidebar');
            const mainConetntMobile = document.querySelector('.main-content-mobile');
            const mainConetntMobileBg = document.querySelector('.main-conent-mobile-bg');
            const table = document.querySelector('.table');
            const navbarHeight = navHeight.offsetHeight;
            // const sideBarHeight = mainSideBar.offsetHeight;
            const mainConetntMobileHeight = mainConetntMobile.offsetHeight;

            const viewportWidth = window.innerWidth;

            if (viewportWidth > 900) {
                // const contentTitle = document.querySelector('.content-title');
                //console.log(window.getComputedStyle(mainConetntMobile).getPropertyValue('padding-top'));

                // const contentTitleHeight = contentTitle.offsetHeight;
                const contentTable = document.querySelector('.content-table');

                contentTable.style.height = `calc(100vh - ${navbarHeight}px - ${window.getComputedStyle(mainConetntMobile).getPropertyValue('padding-top')})`



            }

            if (viewportWidth < 900) {
                const viewPortHeight = window.innerHeight

                const restPage = `calc(100vh - ${navbarHeight}px`;
                const restPagePx = viewPortHeight - navbarHeight;
                const mainConetntMobileHeight = mainConetntMobile.offsetHeight;
                //console.log(restPagePx, mainConetntMobileHeight);

                if (restPagePx > mainConetntMobileHeight) {

                    mainConetntMobileBg.style.height = restPage;
                    mainConetntMobile.style.height = restPage;

                } else {
                    mainConetntMobile.style.height = 'auto';


                    mainConetntMobileBg.style.height = `calc(${mainConetntMobile.offsetHeight}px + 20px)`;


                }



            }
            mainBody.style.top = `${navbarHeight}px`;
        }



        function loadPage(page) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/Controllers/GetActivityLog.php?page=' + page, true);
            document.getElementById('loading-spinner').style.display = 'block';
            const onload = document.getElementById('onrowload');
            onload.classList.add('onrowload');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('loading-spinner').style.display = 'none';
                    // document.getElementById('onrowload').style.display = 'none';
                    onload.classList.remove('onrowload');
                    var response = JSON.parse(xhr.responseText);

                    const dataContainer = document.getElementById('table-rows')

                    dataContainer.innerHTML = response.html;
                    resizeWindow();

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

        window.addEventListener('resize', (()=>{
            resizeWindow();
        }))

    </script>

</body>

</html>