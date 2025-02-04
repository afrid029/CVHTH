<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CVHTH | Sent Donations</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/png" href="Assets/Images/cv.png" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/AllSentDonation.css">
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
        const node = document.querySelector('.nav-sentdon');
        node.style.color = '#68E44C'
        node.style.fontWeight = '600'
    </script>


    <div class="main-body">
        <div class="main-sidebar">
            <div class="sidebar-content">

                <div class="bar-row">
                    <button onclick="handleAdd(true)" class="add-btn">Disburse Fund</button>
                </div>
                <div class="bar-row">
                    <div class="row-type">
                        Charity Balance
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <span id="current">...</span>
                    </div>
                </div>
                <hr class="line">
                <div class="bar-row">
                    <div class="row-type">
                        Donated
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <div>
                            <div style="text-align: end; margin-bottom: 10px" id="spent">...</div>
                            <div style="opacity: 0.6; font-weight: 600;" id="count">By ... Servings</div>
                        </div>

                    </div>
                </div>
                <hr class="line">
                <div class="bar-row">
                    <div class="row-type">
                        Total Recieved Donation
                    </div>
                    <div class="row-value">
                        <div>RS</div>
                        <div id="total">...</div>


                    </div>
                </div>
            </div>


        </div>
        <div class="main-content main-content-mobile">
            <div class="main-conent-mobile-bg"></div>

            <div class="content-title mobile-ani">
                <h3>All Disbursed Donations</h3>
            </div>



            <div class="content-table mobile-ani">
                <div class="table">


                    <div class="table-header">
                        <div>&nbsp;</div>
                        <div>Beneficiary</div>
                        <div>Donor</div>
                        <div style='text-align: center'>Amount</div>
                        <div style='text-align: center'>Date</div>
                        <div style='text-align: center'>Actions</div>

                    </div>

                    <div id="onrowload"></div>
                    <div id="table-rows"></div>
                    <div id="table-pagi"></div>

                    <?php
                    if ($_SESSION['role'] !== 'project manager') { ?>
                        <div class="down-container">
                            <div>
                                <p style="font-family: 'DM Serif Text', serif;">Download Disbursed Donation information</p>
                            </div>
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <div style="margin-bottom: 0px;" class="dateRow">

                                    <label for="">From</label>
                                    <input id="from-date" type="date">
                                </div>
                                <div style="margin-bottom: 0px;" class="dateRow">
                                    <label for="">To</label>
                                    <input id="to-date" type="date">
                                </div>
                                <button id="down-btn" onclick="downloadPDF()" class='down-btn'>&#128195; Download as PDF</button>


                            </div>
                            <div>
                                <small id="date-warning" style="display: none; font-family:'Lato', serif; color: red; text-shadow: 0 0 10px #cd5656;">Select Appropriate range of dates</small>
                            </div>
                        </div>

                    <?php }
                    ?>




                </div>
            </div>

            <div id="loading-spinner" class="loading-spinner"></div>

        </div>
    </div>




    <?php include('Models/AddSentDonation.php') ?>
    <?php include('Models/EditSentDonation.php') ?>
    <?php include('Models/InfoSentDonation.php') ?>
    <?php include('Models/DeleteSentDonation.php') ?>
    <script>
        function resizeWindow() {
            //console.log('resizing');

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
                
                mainConetntMobile.style.height = `calc(100vh - ${navbarHeight}px - ${sideBarHeight}px)`;

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

        const addBtn = document.querySelector('.add-btn');
        addBtn.addEventListener('click', function() {
            //console.log('clicked');

            addBtn.classList.add('clicked')

            setTimeout(() => {
                addBtn.classList.remove('clicked')
            }, 1000)
        })


        function loadPage(page) {
            var xhr = new XMLHttpRequest();
            <?php


            if ($_SESSION['role'] === 'project manager') {
                $prjID = $_SESSION['ID'];
                echo "xhr.open('GET', '/Controllers/GetSentDonations.php?page=' + page + '&pmID=' + '$prjID', true)";
            } else {
                echo "xhr.open('GET', '/Controllers/GetSentDonations.php?page=' + page, true);";
            }

            ?>

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
                        document.getElementById('count').textContent = "By " + response.total + " servings";
                        DisplayNumber(response.total_received, 'total')
                        DisplayNumber(response.total_sent, 'spent')
                        DisplayNumber(response.current_bal, 'current')
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
                 document.querySelector('.main-body').classList.add('no-scroll');
                loadDonors();
                loadProjBene();
                model.style.display = 'flex';

                setTop();
                document.getElementById('select-image').addEventListener('change', PreviewImages);

            } else {
                 document.querySelector('.main-body').classList.remove('no-scroll');
                model.style.display = 'none';
                document.querySelectorAll('.dropdown-container').forEach((ele) => {
                    ele.style.display = 'none'
                });
                document.getElementById('select-donor').removeAttribute('value')
                document.getElementById('select-donor-value').removeAttribute('value')
                document.getElementById('select-date').value = ''
                document.getElementById('select-project').removeAttribute('value')
                document.getElementById('select-project-value').removeAttribute('value')
                document.getElementById('select-beneficent').removeAttribute('value')
                document.getElementById('select-beneficent-value').removeAttribute('value')
                document.getElementById('select-amount').value = ''
                document.getElementById('select-purpose').value = ''
                document.getElementById('donorSearchkey').value = ''
                document.getElementById('projectSearchkey').value = ''
                document.getElementById('beneficentSearchkey').value = ''


                document.getElementById('select-beneficent-cont').style.display = 'none';

                document.getElementById('select-image').value = '';
                document.getElementById('preview-container').innerHTML = '';

                document.getElementById('submit').disabled = true;

                document.getElementById('select-image').removeEventListener('change', PreviewImages);

                document.getElementById('donorSearchkey').removeEventListener('input', donorSearchListener);
                document.getElementById('dropdown-list-donor').removeEventListener('click', selectDonors);

                document.getElementById('projectSearchkey').removeEventListener('input', projectSearchListener);
                document.getElementById('dropdown-list-project').removeEventListener('click', selectProjects)

                document.getElementById('beneficentSearchkey').removeEventListener('input', BeneSearchListener);
                document.getElementById('dropdown-list-beneficent').removeEventListener('click', selectBeneficents);

                // document.getElementById('searchkey').removeEventListener('input', donorSearchListener);
                // document.getElementById('dropdown-list').removeEventListener('click', selectDonor)

            }
        }

        function Edit(ID) {
             document.querySelector('.main-body').classList.add('no-scroll');
            const model = document.getElementById('editModel');
           
            editLoadDonors();
            editLoadProjBene(ID);

            editSetTop();
             model.style.display = 'flex';
            

        }

        function Delete(ID) {

            document.getElementById('del-id').value = ID;
            document.getElementById('deleteModel').style.display = 'flex'

        }

        function closeEdit() {
             document.querySelector('.main-body').classList.remove('no-scroll');
            document.getElementById('editModel').style.display = 'none';
            document.getElementById('edit-not-enough').style.display = "none";

    

            document.querySelectorAll('.dropdown-container').forEach((ele) => {
                ele.style.display = 'none'
            });

            document.getElementById('editDonorSearchkey').value = ''
            document.getElementById('editProjectSearchkey').value = ''
            document.getElementById('editBeneficentSearchkey').value = ''

            document.getElementById('editDonorSearchkey').removeEventListener('input', editDonorSearchListener);
            document.getElementById('edit-dropdown-list-donor').removeEventListener('click', editSelectDonors);

            document.getElementById('editProjectSearchkey').removeEventListener('input', editProjectSearchListener);
            document.getElementById('edit-dropdown-list-project').removeEventListener('click', editSelectProjects)

            document.getElementById('editBeneficentSearchkey').removeEventListener('input', editBeneSearchListener);
            document.getElementById('edit-dropdown-list-beneficent').removeEventListener('click', editSelectBeneficents);
        }

        function moreInfo(role, ID) {
             document.querySelector('.main-body').classList.add('no-scroll');
            sentDonationMoreInfo(ID, role);
             document.getElementById('viewModel').style.display = 'flex';


        }

        function closeView() {
             document.querySelector('.main-body').classList.remove('no-scroll');
            document.getElementById('viewModel').style.display = 'none';
        }

        <?php 
            if($_SESSION['role'] !== 'project manager') { ?>
                const dowonToday = new Date();
        const downLocalDate = dowonToday.toLocaleDateString('en-CA');
        // Set the max attribute to today's date
        document.getElementById('from-date').setAttribute('max', downLocalDate);
        document.getElementById('to-date').setAttribute('max', downLocalDate);

            <?php }
        ?>

       
        function downloadPDF() {
            const fromDate = document.getElementById('from-date');
            const toDate = document.getElementById('to-date');

            // fromDate.style.boxShadow = '0 0 5px red';
            // toDate.style.boxShadow = '0 0 5px red';

            if (fromDate.value === '' && toDate.value === '') {
                fromDate.style.boxShadow = '0 0 5px red';
                toDate.style.boxShadow = '0 0 5px red';
                return;
            }
            if (fromDate.value !== '' && toDate.value === '') {
                fromDate.style.boxShadow = '0 0 5px green';
                toDate.style.boxShadow = '0 0 5px red';
                return;
            }
            if (fromDate.value === '' && toDate.value !== '') {
                fromDate.style.boxShadow = '0 0 5px red';
                toDate.style.boxShadow = '0 0 5px green';
                return;
            }

            if (fromDate.value > toDate.value) {
                fromDate.style.boxShadow = '0 0 5px red';
                toDate.style.boxShadow = '0 0 5px red';
                fromDate.value = '';
                toDate.value = '';
                document.getElementById('date-warning').style.display = 'block';
                return;
            }

            document.getElementById('date-warning').style.display = 'none';
            fromDate.style.boxShadow = '0 0 5px green';
            toDate.style.boxShadow = '0 0 5px green';

            const btn = document.getElementById('down-btn');
            btn.disabled = true;
            btn.innerHTML = '&#128191; Downloading...';

            const xhr = new XMLHttpRequest();

            xhr.open('POST', '/Controllers/DownloadInfo.php', true);

            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const response = JSON.parse(xhr.responseText);
                    //console.log(response.data);

                    SaveDoc(response.data, fromDate.value, toDate.value);

                }
            }

            //console.log(fromDate.value, toDate.value);


            const param = 'type=sentdonation&from=' + fromDate.value + '&to=' + toDate.value;
            xhr.send(param);

            // //console.log('Processing....');

        }

        function SaveDoc(data, from, to) {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // //console.log(doc.getFontList());


            // Add title
            doc.setFontSize(18);
            doc.text('Donation Disbursed | CVHTH', 20, 20);

            doc.setFontSize(12);
            doc.setTextColor('rgb(168, 167, 167)');
            doc.setFont('Helvetica', 'bold');
            doc.text(`From: ${from}    To: ${to}`, 20, 30);
            // doc.text('Donation Received | CVHTH', 20, 20);

            // Define the table columns and data
            const columns = ["Disbursed ID", "Beneficiary Name", "Donor Name", "Purpose", "Amount", "Date"];
            const rows = data.map(item => [item.ID, item.benname, item.donname,item.purpose, item.amount, item.date]);

            // Generate the table
            doc.autoTable({
                head: [columns],
                body: rows,
                startY: 40, // Set the start position for the table
                theme: 'striped', // Add a striped table style (optional)
                pageBreak: 'auto',
                headStyles: {
                    fillColor: [41, 128, 185],
                    textColor: [255, 255, 255]
                }, // Table header styles
                margin: {
                    top: 10
                }, // Margin around the table
            });

            // Output the PDF
            doc.save(`Donation Disbursed - CVHTH_From${from}To${to}.pdf`);
            const btn = document.getElementById('down-btn');
            btn.style.backgroundColor = '#20B2AF';
            btn.innerHTML = '&#128210; PDF Downloaded';

            setTimeout(() => {
                btn.disabled = false;
                btn.style.backgroundColor = '#024b06';
                btn.innerHTML = '&#128195; Download as PDF';
                document.getElementById('from-date').value = '';
                document.getElementById('to-date').value = '';
            }, 3000)
        }

        window.addEventListener("resize", (() => {
            resizeWindow();
            setTop();
            editSetTop();
            ViewSetTop();
        }));
    </script>

</body>

</html>