<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>CVHTH | Projects</title>
    <link rel="icon" type="image/png" href="Assets/Images/cv.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/AllProjects.css">


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

        if ($passedArray['role'] === 'admin' || $passedArray['role'] === 'superadmin' || $passedArray['role'] === 'project manager') {
            $_SESSION['ID'] = $passedArray['ID'];
            $_SESSION['role'] = $passedArray['role'];
            $_SESSION['fname'] = $passedArray['fname'];
        } else {
            header('Location: /');
        }
    }

    include('Components/NavBar.php') ?>


    <script>
        const node = document.querySelector('.nav-projects');
        node.style.color = '#D5BB43'
        node.style.fontWeight = '600'
    </script>


    <div class="main-body">
        <div class="main-sidebar">
            <div class="sidebar-content">

                <div class="bar-row">
                    <?php
                    if ($_SESSION['role'] !== 'project manager') {
                        echo "<button onclick='handleAdd(true)' class='add-btn'>Create Project</button>";

                        echo "<script>
                                const addBtn = document.querySelector('.add-btn');
                                addBtn.addEventListener('click', function() {
                                    addBtn.classList.add('clicked')
                                    setTimeout(() => {
                                        addBtn.classList.remove('clicked')
                                    }, 1000)
                                 })
                            </script>";
                    }
                    ?>

                </div>
                <div class="bar-row">
                    <div class="row-type">
                        Current Projects
                    </div>
                    <div class="row-value">
                        <!-- <div>RS</div> -->
                        <div id="current">...</div>
                    </div>
                </div>
                <hr class="line">
                
            </div>


        </div>
        <div class="main-content main-content-mobile">
            <div class="main-conent-mobile-bg"></div>

            <div class="content-title mobile-ani">
                <h3>All Projects</h3>
            </div>



            <div class="content-table mobile-ani">
                <div class="table">


                    <div class="table-header">
                        <div>&nbsp;</div>
                        <div>Project</div>
                        <div>Description</div>
                        <div>Manager(s)</div>
                        <div style='text-align:center'>Grantees</div>
                        <?php 
                            if($_SESSION['role'] !== 'project manager'){
                                echo "<div style='text-align:center'>Actions</div>";
                            }
                        ?>

                    </div>

                    <div id="onrowload"></div>
                    <div id="table-rows"></div>
                    <div id="table-pagi"></div>




                </div>
            </div>

            <div id="loading-spinner" class="loading-spinner"></div>

        </div>
    </div>

    <!--     
    <footer>
        <div class="footer"></div>

    </footer> -->
    <?php include('Models/AddProject.php') ?>
    <?php include('Models/EditProject.php') ?>
    <?php include('Models/InfoProject.php') ?>
    <?php include('Models/DeleteProjectModel.php') ?>
    <script>
        function resizeWindow() {
            //console.log('resizing');

            const navHeight = document.querySelector('.navbar');
            const mainBody = document.querySelector('.main-body');
            const mainSideBar = document.querySelector('.main-sidebar');
            const mainConetntMobile = document.querySelector('.main-content-mobile');
            const mainConetntMobileBg = document.querySelector('.main-conent-mobile-bg');
            // const contentTitle = document.querySelector('.content-title');
            // //console.log(navHeight.offsetHeight);
            const navbarHeight = navHeight.offsetHeight;
            const sideBarHeight = mainSideBar.offsetHeight;
            const mainConetntMobileHeight = mainConetntMobile.offsetHeight;

            const viewportWidth = window.innerWidth;

            if (viewportWidth > 900) {
                const contentTitle = document.querySelector('.content-title');
                //console.log(window.getComputedStyle(mainConetntMobile).getPropertyValue('padding-top'));

                const contentTitleHeight = contentTitle.offsetHeight;
                const contentTable = document.querySelector('.content-table');

                contentTable.style.height = `calc(100vh - ${navbarHeight}px - ${contentTitleHeight}px - ${window.getComputedStyle(mainConetntMobile).getPropertyValue('padding-top')})`



            }

            if (viewportWidth < 900) {
                
                const viewPortHeight = window.innerHeight

                const restPage = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;
                const restPagePx = viewPortHeight - navbarHeight - sideBarHeight;
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

        
        function DisplayNumber(targetNumber, ID) {
            const numberElement = document.getElementById(ID);
            let currentNumber = 0;
            const duration = 1000; // 2 seconds
            const incrementTime = 100;
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

            //console.log('<?php echo $_SESSION['ID'] ?>');
            

            <?php
            
            if($_SESSION['role'] === 'project manager'){
                    $prjID = $_SESSION['ID'];
                    echo "xhr.open('GET', '/Controllers/GetAllProjects.php?page=' + page + '&pmID=' + '$prjID', true)";
                }else {
                    echo "xhr.open('GET', '/Controllers/GetAllProjects.php?page=' + page, true);";
                }

            ?>
            // xhr.open('GET', '/Controllers/GetAllProjects.php?page=' + page, true);
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

                    if (page === 1) {
                        // document.getElementById('count').textContent = "From " + response.total + " donations";
                        DisplayNumber(response.total, 'current')
                    }
                }
            };

            xhr.send();
        }

        // Load the first page initially
        window.onload = function() {
            loadPage(1);
        };

        function handleAdd(value) {
            const model = document.getElementById('addModel');
            
            if (value) {
                // loadProjects();
                // loadDonors();
                 document.querySelector('.main-body').classList.add('no-scroll');
                loadManagers();
                loadBeneficents();
                model.style.display = 'flex';
                setTop();
                // window.addEventListener('resize', (() => {
                //     setTop();
                // }))
            } else {
                // //console.log('falsseee');
                 document.querySelector('.main-body').classList.remove('no-scroll');

                model.style.display = 'none';
                document.querySelectorAll('.dropdown-container').forEach((ele) => {
                    ele.style.display = 'none'
                });

                document.getElementById('select-manager').removeAttribute('value');
                document.getElementById('select-manager-value').removeAttribute('value');
                document.getElementById('select-beneficent').removeAttribute('value')
                document.getElementById('select-beneficent-value').removeAttribute('value')
                document.getElementById('select-pname').value = ''
                document.getElementById('select-description').value = ''
                document.getElementById('managerSearchkey').value = ''
                document.getElementById('beneficentSearchkey').value = ''
                document.getElementById('submit').disabled = true;

                document.getElementById('managerSearchkey').removeEventListener('input', managerSearchListener);
                document.getElementById('dropdown-list-manager').removeEventListener('click', selectManagers);

                document.getElementById('beneficentSearchkey').removeEventListener('input', beneficentSearchListener);
                document.getElementById('dropdown-list-beneficent').removeEventListener('click', selectBeneficents)


            }
        }


        function Edit(ID) {
             document.querySelector('.main-body').classList.add('no-scroll');
            const model = document.getElementById('editModel');
           
            editSetTop();
            editLoadManagers();
            editLoadBeneficents(ID);
             model.style.display = 'flex';

        }

        function Delete(ID) {

            document.getElementById('del-id').value = ID;
            document.getElementById('deleteModel').style.display = 'flex'

        }

        function closeEdit() {
             document.querySelector('.main-body').classList.remove('no-scroll');
            document.getElementById('editModel').style.display = 'none';
            document.querySelectorAll('.dropdown-container').forEach((el) => {
                el.style.display = 'none';
            })

            document.getElementById('editManagerSearchkey').value = ''
            document.getElementById('editBeneficentSearchkey').value = ''

            document.getElementById('editManagerSearchkey').removeEventListener('input', editManagerSearchListener);
            document.getElementById('edit-dropdown-list-manager').removeEventListener('click', editSelectManagers);

            document.getElementById('editBeneficentSearchkey').removeEventListener('input', editBeneficentSearchListener);
            document.getElementById('edit-dropdown-list-beneficent').removeEventListener('click', editSelectBeneficents)

          
        }

        function moreInfo(role, ID) {
             document.querySelector('.main-body').classList.add('no-scroll');
            projectMoreInfo(ID, role);
            document.getElementById('viewModel').style.display = 'flex';


        }

        function closeView() {
             document.querySelector('.main-body').classList.remove('no-scroll');
            document.getElementById('viewModel').style.display = 'none';
        }

        window.addEventListener("resize", (() => {
            resizeWindow();
            editSetTop();
            setTop();
            ViewSetTop();
        }));
    </script>

</body>

</html>