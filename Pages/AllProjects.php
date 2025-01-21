<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/AllProjects.css">


</head>

<body style="width: 100vw; display:contents;">

<?php include('../Components/NavBar.php') ?>
   

    <div class="main-body">
        <div class="main-sidebar">
            <div class="sidebar-content">

                <div class="bar-row">
                    <button onclick="handleAdd(true)" class="add-btn">Create Project</button>
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
                <!-- <div class="bar-row">
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
                        Total Recieved Donation
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <div>
                            <div style="text-align: end; margin-bottom: 10px" id="total">...</div>
                            <div style="opacity: 0.6; font-weight: 600;" id="count">From ... donations</div>
                        </div>
                    </div>
                </div> -->
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
                        <div style='text-align:center' >Grantees</div>
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

    <!--     
    <footer>
        <div class="footer"></div>

    </footer> -->
    <?php include('/CVHTH/Models/AddProject.php') ?>
    <script>
        

        function resizeWindow() {
            console.log('resizing');

            const navHeight = document.querySelector('.navbar');
            const mainBody = document.querySelector('.main-body');
            const mainSideBar = document.querySelector('.main-sidebar');
            const mainConetntMobile = document.querySelector('.main-content-mobile');
            const mainConetntMobileBg = document.querySelector('.main-conent-mobile-bg');
            // const contentTitle = document.querySelector('.content-title');
            // console.log(navHeight.offsetHeight);
            const navbarHeight = navHeight.offsetHeight;
            const sideBarHeight = mainSideBar.offsetHeight;
            const mainConetntMobileHeight = mainConetntMobile.offsetHeight; 

            const viewportWidth = window.innerWidth;

            if(viewportWidth > 900 ){
                const contentTitle = document.querySelector('.content-title');
                console.log(window.getComputedStyle(mainConetntMobile).getPropertyValue('padding-top'));
                
                const contentTitleHeight = contentTitle.offsetHeight;
                const contentTable = document.querySelector('.content-table');

                contentTable.style.height = `calc(100vh - ${navbarHeight}px - ${contentTitleHeight}px - ${window.getComputedStyle(mainConetntMobile).getPropertyValue('padding-top')})`



            }

            if (viewportWidth < 900) {
                // const contentTitle = document.querySelector('content-title');
                // const contentTable = document.querySelector('content-table');
                const viewPortHeight = window.innerHeight

                const restPage = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;
                const restPagePx = viewPortHeight - navbarHeight - sideBarHeight;
                const mainConetntMobileHeight = mainConetntMobile.offsetHeight;
                console.log(restPagePx, mainConetntMobileHeight);

                if (restPagePx > mainConetntMobileHeight) {
                    console.log('great');
                    console.log('rest ', restPagePx);

                    mainConetntMobileBg.style.height = restPage;
                     mainConetntMobile.style.height = restPage;

                    // requestAnimationFrame(()=>{
                       
                    // })
                } else {
                    console.log('less');

                    // requestAnimationFrame(()=>{
                        
                    // })
                    mainConetntMobile.style.height = 'auto';
                    
                    // requestAnimationFrame(() => {
                    //     console.log(mainConetntMobile.offsetHeight);

                    //     // Apply the new height to the background
                        
                    // });
                    mainConetntMobileBg.style.height = `calc(${mainConetntMobile.offsetHeight}px + 20px)`;
                }


                // const contentTitleHeight = contentTitle.offsetHeight;
                // const contentTableHeight = contentTable.off

                // mainConetntMobileBg.style.height = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;
                // mainConetntMobileBg.style.height = `calc(${mainConetntMobileHeight}px + 20px)`;
                // mainConetntMobile.style.height = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;

            }

            // mainConetntMobileBg.style.height = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;
            // mainConetntMobile.style.height = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;


            // Get the navbar height
            // const sideBarHeight = mainSideBar.offsetHeight; // Get the navbar height
            // mainConetntMobileBg.style.height = `${mainConetntMobileHeight}px`;
            // console.log(mainConetntMobileHeight);

            // setTimeout(()=> {

            // },800);

            // Set the height of the main-body using calc with the navbar height
            // mainBody.style.height = `calc(100% - ${navbarHeight}px)`;
            mainBody.style.top = `${navbarHeight}px`;
            // contentTitle.style.top = `${navbarHeight}px`;
            // mainConetntMobile.style.height = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;
            // console.log(mainConetntMobile.style.height,navbarHeight, sideBarHeight);
        }

        // resizeWindow();

        window.addEventListener("resize", resizeWindow);
        // console.log(navbarHeight, sideBarHeight);


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

        // DisplayNumber(70000, 'current');
        // DisplayNumber(20000, 'spent');
        // DisplayNumber(90000, 'total');

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
            xhr.open('GET', '/Controllers/GetAllProjects.php?page=' + page, true);
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
                loadManagers();
                loadBeneficents();
                model.style.display = 'flex';
                setTop();
                window.addEventListener('resize', (() => {
                    setTop();
                }))
            } else {
                // console.log('falsseee');

                model.style.display = 'none';
                document.querySelectorAll('.dropdown-container').forEach((ele) => {
                    ele.style.display = 'none'
                });
               
                document.getElementById('select-manager').removeAttribute('value');
                document.getElementById('select-manager-value').removeAttribute('value');
                document.getElementById('select-beneficent').removeAttribute('value')
                document.getElementById('select-beneficent-value').removeAttribute('value')
                document.getElementById('select-pname').value = ''
                document.getElementById('select-description').value= ''
                document.getElementById('managerSearchkey').value = ''
                document.getElementById('beneficentSearchkey').value = ''
                document.getElementById('submit').disabled = true;

                document.getElementById('managerSearchkey').removeEventListener('input', managerSearchListener);
                document.getElementById('dropdown-list-manager').removeEventListener('click', selectDonors);

                document.getElementById('beneficentSearchkey').removeEventListener('input', beneficentSearchListener);
                document.getElementById('dropdown-list-beneficent').removeEventListener('click', selectBeneficents)

                // document.getElementById('beneficentSearchkey').removeEventListener('input', BeneSearchListener);
                // document.getElementById('dropdown-list-beneficent').removeEventListener('click', selectBeneficents);

                // document.getElementById('donorSearchkey').removeEventListener('input', donorSearchListener);
                // document.getElementById('dropdown-list-project').removeEventListener('click', selectProjects);
                // document.getElementById('dropdown-list-donor').removeEventListener('click', selectDonors)

                // document.getElementById('dropdown-list-donor').removeEventListener('click');
                // document.getElementById('dropdown-list-project').removeEventListener('click')
                // document.getElementById('donorSearchkey').removeEventListener('input');
                // document.getElementById('projectSearchkey').removeEventListener('input');

            }
        }
    </script>

</body>

</html>