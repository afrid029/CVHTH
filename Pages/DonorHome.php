<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CVHTH | Donor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="Assets/CSS/DonorHome.css">


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

        if ($passedArray['role'] == 'donor') {
           $_SESSION['ID'] = $passedArray['ID'];
           $_SESSION['role'] = $passedArray['role'];
           $_SESSION['name'] = $passedArray['fname']. ' ' . $passedArray['lname'];
        } else {
           header('Location: /');
        }
    }

    include('Components/NavBar.php') ?>

    <div class="main-body">
        <div class="main-sidebar">
            <div class="sidebar-content">

            <div style="margin-bottom: 25px;"  class="bar-row">
                    
                <div  class="row-type">
                       <h1 style="color: #022202;">HI,</h1>
                    </div>
                    <div class="row-value">
                        <h3 id="donor-name" style="color: #012001ab;"> .... </h3>
                    </div>
                </div>

                <div class="bar-row">
                    <div class="row-type">
                        Your Total Contribution
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <span id="current">...</span>
                    </div>
                </div>
                <hr class="line">
                <div class="bar-row">
                    <div class="row-type">
                        Disbursed Amount
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <div>
                            <div style="text-align: end; margin-bottom: 10px" id="spent">...</div>
                            <div style="opacity: 0.6; font-weight: 600;" id="count">via ... Allocations</div>
                        </div>

                    </div>
                </div>
                <hr class="line">
                
            </div>


        </div>
        <div class="main-content main-content-mobile">
            <div class="main-conent-mobile-bg"></div>

            <div class="content-title mobile-ani">
                <h3>Disbursed Donations</h3>
            </div>



            <div class="content-table mobile-ani">
                <div class="table">


                    <div class="table-header">
                        <div>&nbsp;</div>
                        <div>Beneficiary</div>
                        <div style='text-align: center'>Amount</div>
                        <div style='text-align: center'>Project</div>
                        <div style='text-align: center'>Date</div>

                    </div>

                    <div id="onrowload"></div>
                    <div id="table-rows"></div>
                    <div id="table-pagi"></div>




                </div>
            </div>

            <div id="loading-spinner" class="loading-spinner"></div>

        </div>
    </div>


    <?php include('Models/InfoDonorView.php') ?>
    
    <script>
        document.getElementById('donor-name').textContent = "<?php echo $_SESSION['name']; ?>";
        let donorData;
        function resizeWindow() {
            // console.log('resizing');

            const navHeight = document.querySelector('.navbar');
            const mainBody = document.querySelector('.main-body');
            const mainSideBar = document.querySelector('.main-sidebar');
            const mainConetntMobile = document.querySelector('.main-content-mobile');
            const mainConetntMobileBg = document.querySelector('.main-conent-mobile-bg');
            const navbarHeight = navHeight.offsetHeight;
            const sideBarHeight = mainSideBar.offsetHeight;


            const viewportWidth = window.innerWidth;

            if (viewportWidth > 900) {
                const contentTitle = document.querySelector('.content-title');
              
                const contentTitleHeight = contentTitle.offsetHeight;
                const contentTable = document.querySelector('.content-table');

                contentTable.style.height = `calc(100vh - ${navbarHeight}px - ${contentTitleHeight}px - ${window.getComputedStyle(mainConetntMobile).getPropertyValue('padding-top')})`



            }

            if (viewportWidth < 900) {
                const viewPortHeight = window.innerHeight

                const restPage = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;
                const restPagePx = viewPortHeight - navbarHeight - sideBarHeight;
                const mainConetntMobileHeight = mainConetntMobile.offsetHeight;
               
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

        


        function loadPage(page) {
            var xhr = new XMLHttpRequest();
            const ID = '<?php echo $_SESSION['ID']; ?>';
            xhr.open('GET', '/Controllers/GetServedDonation.php?ID='+ ID +'&page=' + page, true);
            document.getElementById('loading-spinner').style.display = 'block';
            const onload = document.getElementById('onrowload');
            onload.classList.add('onrowload');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('loading-spinner').style.display = 'none';
                    // document.getElementById('onrowload').style.display = 'none';
                    onload.classList.remove('onrowload');
                    var response = JSON.parse(xhr.responseText);
                    donorData = response.data;
                    // console.log(donorData);
                    

                    const dataContainer = document.getElementById('table-rows')

                    dataContainer.innerHTML = response.html;
                    resizeWindow();

                    dataContainer.classList.remove('fade-in'); // Remove the class to reset animation
                    void dataContainer.offsetWidth; // Trigger reflow
                    dataContainer.classList.add('fade-in'); // Apply fade-in animation
                    document.getElementById('table-pagi').innerHTML = response.pagination;

                    if (page === 1) {
                        document.getElementById('count').textContent = "Via " + response.total + " Allocations";
                        // DisplayNumber(response.total_received, 'total')
                        DisplayNumber(response.total_sent, 'current')
                        DisplayNumber(response.total_received, 'spent')
                    }
                }
            };

            xhr.send();
        }

        // Load the first page initially
        window.onload = function() {
            loadPage(1);
        };


        function moreInfo(role, ID){
            
            
            // sentDonationMoreInfo(ID, role);

            const SelectedDon = donorData.filter((el) => (
                el.ID === ID
            ));

            // console.log(SelectedDon);
            

            document.getElementById('don-amount').textContent = 'Amount (Rs) : ' + SelectedDon[0].amount;
            document.getElementById('don-id').textContent = 'Reciept ID : ' + SelectedDon[0].ID;
            document.getElementById('ben-name').innerHTML = SelectedDon[0].ben_fn + ' ' + SelectedDon[0].ben_ln;
            document.getElementById('don-project').innerHTML = SelectedDon[0].name;
            document.getElementById('don-date').textContent = SelectedDon[0].date;
            document.getElementById('don-purpose').textContent = SelectedDon[0].purpose;
            
            document.getElementById('viewModel').style.display = 'flex';

            viewPreviewImages(SelectedDon[0].images);
            ViewSetTop();
           
            
        }

        function closeView(){
            document.getElementById('viewModel').style.display = 'none';
        }

      
        window.addEventListener("resize", (()=> {
            resizeWindow();
            // setTop();
            ViewSetTop();
        }));
    </script>

</body>

</html>