<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/AllUsers.css">


</head>

<body style="width: 100vw; display:contents;">

    <?php include('../Components/NavBar.php') ?>


    <div class="main-body">
        <div class="main-sidebar">
            <div class="sidebar-content">

                <div class="bar-row">
                    <button class="add-btn" onclick="handleAdd(true)">Add User</button>
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
                <hr class="line">
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
            <div class="main-conent-mobile-bg"></div>
            <div style="width: 100%; ">
                <!-- <div class="main-conent-mobile-bg"></div> -->

                <div class="content-title mobile-ani">
                    <h3>Admins</h3>
                </div>



                <div class="content-table mobile-ani">
                    <div class="table">


                        <div class="table-header table-header-admin">
                            <div>Name</div>
                            <div>Email</div>
                            <div>Contact No.</div>
                            <div style='text-align: center'>Functions</div>

                        </div>

                        <div id="onrowload-admin"></div>
                        <div id="table-rows-admin"></div>
                        <div id="table-pagi-admin"></div>

                    </div>
                </div>

                <div id="loading-spinner-admin" class="loading-spinner"></div>
            </div>


            <div style="width: 100%; margin-top: 0.8rem">
                <!-- <div class="main-conent-mobile-bg"></div> -->

                <div class="content-title mobile-ani">
                    <h3>Project Managers</h3>
                </div>



                <div class="content-table mobile-ani">
                    <div class="table">


                        <div class="table-header table-header-pm">
                            <div>Name</div>
                            <div>Email</div>
                            <div>Contact No.</div>
                            <div>Project</div>
                            <div style='text-align: center'>Functions</div>

                        </div>

                        <div id="onrowload-pm"></div>
                        <div id="table-rows-pm"></div>
                        <div id="table-pagi-pm"></div>




                    </div>
                </div>

                <div id="loading-spinner-pm" class="loading-spinner"></div>
            </div>


            <div style="width: 100%; margin-top: 0.8rem">
                <!-- <div class="main-conent-mobile-bg"></div> -->

                <div class="content-title mobile-ani">
                    <h3>Donors</h3>
                </div>



                <div class="content-table mobile-ani">
                    <div class="table">


                        <div class="table-header table-header-donor">
                            <div>&nbsp;</div>


                            <div>Name</div>
                            <div>Contact No.</div>
                            <div style="text-align: center;">Donated (RS)</div>
                            <div style="visibility: hidden" ;></div>
                            <div>DOB</div>
                            <div style='text-align: center'>Functions</div>

                        </div>

                        <div id="onrowload-donor"></div>
                        <div id="table-rows-donor"></div>
                        <div id="table-pagi-donor"></div>




                    </div>
                </div>

                <div id="loading-spinner-donor" class="loading-spinner"></div>
            </div>

        </div>
    </div>

    <!--     
    <footer>
        <div class="footer"></div>

    </footer> -->
    <?php include('/CVHTH/Models/AddUser.php') ?>
    <?php include('/CVHTH/Models/EditUser.php') ?>
    <script>
        function resizeWindow() {
            // console.log('resizing')

            const navHeight = document.querySelector('.navbar');
            const mainBody = document.querySelector('.main-body');
            const mainSideBar = document.querySelector('.main-sidebar');
            const mainConetntMobileBg = document.querySelector('.main-conent-mobile-bg');
            const navbarHeight = navHeight.offsetHeight;
            const sideBarHeight = mainSideBar.offsetHeight;



            const viewportWidth = window.innerWidth;

            if (viewportWidth < 900) {

                const mainConetntMobile = document.querySelector('.main-content-mobile');
                const mainConetntMobileHeight = mainConetntMobile.offsetHeight;
                // console.log(mainConetntMobileHeight);

                mainConetntMobileBg.style.height = `calc(${mainConetntMobileHeight}px + 20px)`;
                // mainConetntMobile.style.height = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;

            }

            mainBody.style.top = `${navbarHeight}px`;
            // contentTitle.style.top = `${navbarHeight}px`;
            // mainConetntMobile.style.height = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;
            // console.log(mainConetntMobile.style.height,navbarHeight, sideBarHeight);
        }

        // resizeWindow();


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

        // DisplayNumber(5, 'admin');
        // DisplayNumber(10, 'prjmgr');
        // DisplayNumber(150, 'donor');
        // DisplayNumber(90000, 'total');


        function adminsload(page) {
            // console.log(page);

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/Controllers/GetUsers.php?page=' + page + '&user=' + encodeURIComponent('admin'), true);
            document.getElementById('loading-spinner-admin').style.display = 'block';
            const onload = document.getElementById('onrowload-admin');
            onload.classList.add('onrowload');

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

        function pmsload(page) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/Controllers/GetUsers.php?page=' + page + '&user=' + encodeURIComponent('project manager'), true);
            document.getElementById('loading-spinner-pm').style.display = 'block';
            const onload = document.getElementById('onrowload-pm');
            onload.classList.add('onrowload');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('loading-spinner-pm').style.display = 'none';
                    // document.getElementById('onrowload').style.display = 'none';
                    onload.classList.remove('onrowload');
                    var response = JSON.parse(xhr.responseText);

                    const dataContainer = document.getElementById('table-rows-pm');
                    // console.log(response.html);


                    dataContainer.innerHTML = response.html;
                    // resizeWindow();

                    dataContainer.classList.remove('fade-in'); // Remove the class to reset animation
                    void dataContainer.offsetWidth; // Trigger reflow
                    dataContainer.classList.add('fade-in'); // Apply fade-in animation
                    document.getElementById('table-pagi-pm').innerHTML = response.pagination;

                    if (page === 1) {
                        // document.getElementById('admin').textContent = "From " + response.total + " donations";
                        DisplayNumber(response.total_received, 'prjmgr')
                    }
                }
            };

            xhr.send();

        }

        function donorload(page) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/Controllers/GetUsers.php?page=' + page + '&user=' + encodeURIComponent('donor'), true);
            document.getElementById('loading-spinner-donor').style.display = 'block';
            const onload = document.getElementById('onrowload-donor');
            onload.classList.add('onrowload');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('loading-spinner-donor').style.display = 'none';
                    // document.getElementById('onrowload').style.display = 'none';
                    onload.classList.remove('onrowload');
                    var response = JSON.parse(xhr.responseText);

                    const dataContainer = document.getElementById('table-rows-donor');
                    // console.log(response.html);


                    dataContainer.innerHTML = response.html;
                    // resizeWindow();

                    dataContainer.classList.remove('fade-in'); // Remove the class to reset animation
                    void dataContainer.offsetWidth; // Trigger reflow
                    dataContainer.classList.add('fade-in'); // Apply fade-in animation
                    document.getElementById('table-pagi-donor').innerHTML = response.pagination;

                    if (page === 1) {
                        // document.getElementById('admin').textContent = "From " + response.total + " donations";
                        DisplayNumber(response.total_received, 'donor')
                    }
                }

                let i = 0;
                resizeWindow();
                const resizeINterval = setInterval(() => {
                    // console.log(i);

                    i++;

                    resizeWindow();

                    if (i == 10) {
                        clearInterval(resizeINterval)
                    }

                }, 1000)
            };

            xhr.send();

        }

        // Load the first page initially
        window.onload = function() {
            adminsload(1);
            pmsload(1);
            donorload(1);

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

        function handleAdd(value) {
            const model = document.getElementById('addModel');
            if (value) {
                loadProjects();
                loadDonors();
                model.style.display = 'flex';
                setTop();
               
            } else {
                console.log('falsseee');

                model.style.display = 'none';
                document.getElementById('dropdown-container-project').style.display = 'none';
                document.getElementById('dropdown-container-donor').style.display = 'none';
                document.getElementById('select-fname').value = '';
                document.getElementById('select-lname').value = '';
                document.getElementById('select-email').value = '';
                document.getElementById('select-role').value = 'none';
                document.getElementById('select-contact').value = '';
                document.getElementById('select-dob').value = '';
                document.getElementById('select-donor').removeAttribute('value');
                document.getElementById('select-donor-value').removeAttribute('value');
                document.getElementById('select-project').removeAttribute('value');
                document.getElementById('select-project-value').removeAttribute('value');
                document.getElementById('projectSearchkey').value = '';
                document.getElementById('donorSearchkey').value = '';

                document.getElementById('select-project-cont').style.display = 'none';
                document.getElementById('select-donor-cont').style.display = 'none';
                document.getElementById('select-dob-cont').style.display = 'none';
                document.getElementById('submit').disabled = true;

                document.getElementById('projectSearchkey').removeEventListener('input', projectSearchListener);

                document.getElementById('donorSearchkey').removeEventListener('input', donorSearchListener);
                document.getElementById('dropdown-list-project').removeEventListener('click', selectProjects);
                document.getElementById('dropdown-list-donor').removeEventListener('click', selectDonors)


            }
        }

        function Edit(ID){
            const model = document.getElementById('editModel');
            model.style.display = 'flex';
            editSetTop();
            editLoadDonors(); 
            editLoadProjects();
            getSingleUser(ID);

        }

        function Delete(){

        }

        function closeEdit(){
            document.getElementById('editModel').style.display = 'none';
            document.querySelectorAll('.dropdown-container').forEach((el) => {
                el.style.display = 'none';
            })

            document.getElementById('editProjectSearchkey').removeEventListener('input', editProjectSearchListener);
            document.getElementById('edit-dropdown-list-project').removeEventListener('click', editSelectProjects)

            document.getElementById('editDonorSearchkey').removeEventListener('input', editDonorSearchListener);
            document.getElementById('edit-dropdown-list-donor').removeEventListener('click', editSelectDonors)
        }

        window.addEventListener("resize", (()=>{
            resizeWindow();
            editSetTop();
            setTop();
        }));

    </script>

</body>

</html>