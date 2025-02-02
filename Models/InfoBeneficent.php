<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Assets/CSS/MoreInfo.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>


</head>

<body>
    <div class="modal-overlay" id="viewModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div id="popupImage" style="position: fixed; height: 100vh; display:none; background-color: #000000d4; justify-content: center; width: 100vw; z-index: 910">
                
                <img id="popupSrc" style="object-fit: contain; width: 100vw"  alt="">
                <div class="popClose" onclick="closePop()">Close</div>
            </div>
            <div class="banner view-banner">
                <div class="user">
                    <h4 id="ben-name"></h4>
                    <h6 id="ben-id"></h6>
                    <h6 id="ben-amount"></h6>
                </div>
                <div onclick="closeView()" class='close'>Close</div>
            </div>

            <div id="ben-info">
                <div class="infoRow">
                    <div class="infoTitle">
                        NIC
                    </div>
                    <div class="info" id="ben-nic">
                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        Gender
                    </div>
                    <div class="info" id="ben-gender">
                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        Date of Birth
                    </div>
                    <div class="info" id="ben-dob">
                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        Address
                    </div>
                    <div class="info" id="ben-address">
                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        GS Division
                    </div>
                    <div class="info" id="ben-gs">
                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        Education Qualification
                    </div>
                    <div class="info" id="ben-grade">
                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        School
                    </div>
                    <div class="info" id="ben-school">
                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        Dependants
                    </div>
                    <div class="info" id="ben-dep">

                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        Projects
                    </div>
                    <div class="info" id="ben-prj">

                    </div>
                </div>
                <hr class="line">

                <div id="view-preview-container" style="display: flex; justify-content: center; gap: 5px; flex-wrap:wrap; margin-top: 10px; margin-bottom: 20px; margin-left: 10px"></div>

                <div style="margin-bottom: 20px !important;" class="down-container">
                    <div>
                        <p style="font-family: 'DM Serif Text', serif;">Download Donation information</p>
                    </div>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <div style="margin-bottom: 0px;" class="dateRow">

                            <label for="">From</label>
                            <input id="from-date" type="date">
                        </div>
                        <div style="margin-bottom: 0px;" class="dateRow">
                            <label for="">To</label>
                            <input id="to-date" type="date" placeholder='To Date'>
                        </div>
                        <button id="down-btn" style="background-color: rgb(63 41 16);" onclick="downloadPDF()" class='down-btn'>&#128195; Download as PDF</button>


                    </div>
                    <div>
                        <small id="date-warning" style="display: none; font-family:'Lato', serif; color: red; text-shadow: 0 0 10px #cd5656;">Select Appropriate range of dates</small>
                    </div>
                </div>


            </div>

        </div>
    </div>


        <script>

            let printData;
            function beneficentMoreInfo(ID, role) {
                var xhr = new XMLHttpRequest();


                xhr.open('GET', '/Controllers/GetMoreInfo.php?ID=' + ID + '&type=' + encodeURIComponent(role), true);
              
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                      
                        const {
                            data
                        } = JSON.parse(xhr.responseText);
                        //console.log(data);

                        printData = data;

                        document.getElementById('ben-name').textContent = data.firstName + ' ' + data.lastName;
                        document.getElementById('ben-id').textContent = 'Benificent ID : ' + data.ID;
                        document.getElementById('ben-amount').textContent ='Disbursed Amount (Rs) : '+ data.sent;
                        document.getElementById('ben-nic').textContent = data.NIC;
                        document.getElementById('ben-gender').textContent = data.sex;
                        document.getElementById('ben-dob').textContent = data.dob;
                        document.getElementById('ben-address').textContent = data.address;
                        document.getElementById('ben-gs').textContent = data.gsDivision;
                        document.getElementById('ben-grade').innerHTML = data.grade;
                        document.getElementById('ben-school').innerHTML = data.school;

                        const depContainer = document.getElementById('ben-dep');
                        depContainer.innerHTML = "";

                        if (data.dependants) {
                            const depArray = data.dependants.split(', ');
                            depArray.forEach((dep) => {
                                const div = document.createElement('div');
                                div.innerHTML = '&#10294; ' + dep;
                                depContainer.appendChild(div)
                            })
                        }else {
                            depContainer.innerHTML = "<i>Not Assigned</i>"
                        }

                        const prjContainer = document.getElementById('ben-prj');
                        prjContainer.innerHTML = "";

                        if (data.projects) {
                            const prjArray = data.projects.split(', ');
                            prjArray.forEach((prj) => {
                                const div = document.createElement('div');
                                div.innerHTML = '&#10294; ' + prj;
                                prjContainer.appendChild(div)
                            })
                        }else {
                            prjContainer.innerHTML = "<i>Not Assigned</i>"
                        }

                        // console.log(data);
                        




                        // ViewSetTop();

                        viewPreviewImages(data.images);

                    }
                };


                xhr.send();
            }

            function ViewSetTop() {
                //console.log('Serting top');

                const banner = document.querySelector('.view-banner');
                const top = document.querySelector('#ben-info');
                const div = document.querySelector('.edit-div');


                const bannerHeight = banner.offsetHeight;
                // //console.log(bannerHeight);

                // top.style.top = `calc(${bannerHeight}px + 10px)`;



                // div.style.height = `calc(100vh - ${bannerHeight}px)`;
            }

            function viewPreviewImages(data) {
                const imgContainer = document.getElementById('view-preview-container');
                imgContainer.innerHTML = ""

                const imgArray = data.split(', ');
                //console.log(imgArray);
                

                imgArray.forEach((imgSrc) => {
                    //console.log(imgSrc);
                    
                 
                    const divEl = document.createElement('div');
                    divEl.style.width = '100px';
                    divEl.style.height = '100px';
                    divEl.style.position = 'relative';
                    divEl.style.display = 'flex'
                    divEl.style.gap = '5px'
                    divEl.style.backgroundColor = '#CBCBCB'
                    divEl.style.borderRadius = '10px'

                    const imgElement = document.createElement('img');
                    imgElement.src = imgSrc;
                    imgElement.alt = 'Image Not Available';
                    imgElement.style.borderRadius = '10px';
                    imgElement.style.width = '100px'; // Optional: resize the image for preview
                    imgElement.style.objectFit = 'cover'; // Optional: resize the image for preview
                    imgElement.style.cursor = 'pointer';
                    imgElement.onclick = function() {
                        popImage(imgSrc);
                    }
                    

                    divEl.appendChild(imgElement)
                    imgContainer.appendChild(divEl);
                
                })
                // reader.readAsDataURL(file); // Read the file as a data URL for previewing

            }

            function popImage(src) {
                // console.log(src);
                document.getElementById('popupImage').style.display = 'flex'
                document.getElementById('popupSrc').src = src;

                
            }

            function closePop(){
                document.getElementById('popupImage').style.display = 'none'
            }

            const dowonToday = new Date();
        const downLocalDate = dowonToday.toLocaleDateString('en-CA');
    // Set the max attribute to today's date
        document.getElementById('from-date').setAttribute('max', downLocalDate);
        document.getElementById('to-date').setAttribute('max', downLocalDate);

        
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


        const param = 'type=beneficent&from=' + fromDate.value + '&to=' + toDate.value + '&ID=' + printData.ID;
        xhr.send(param);

        // //console.log('Processing....');

    }

    function SaveDoc(data, from, to) {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        // console.log(doc.getFontList());


        // Add title
        doc.setFontSize(18);
        doc.text(`Donation Disbursed | ${printData.firstName} ${printData.lastName}`, 20, 20);

        doc.setFontSize(12);
        doc.setTextColor('rgb(168, 167, 167)');
        doc.setFont('Helvetica', 'bold');
        doc.text(`From: ${from}    To: ${to}`, 20, 30);
        // doc.text('Donation Received | CVHTH', 20, 20);

        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Beneficiary : `, 20, 40);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${printData.firstName} ${printData.lastName} (${printData.ID})`, 70, 40);

        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`NIC : `, 20, 45);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${printData.NIC}`, 70, 45);


        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Gender : `, 20, 50);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${printData.sex}`, 70, 50);

        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Date of birth : `, 20, 55);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${printData.dob}`, 70, 55);

        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Address : `, 20, 60);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${printData.address}`, 70, 60);

        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`GS Division : `, 20, 65);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${printData.gsDivision}`, 70, 65);

        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Education Qualification : `, 20, 70);

        console.log(printData.grade);
        

        grade = printData.grade === '<i>Not Provided</i>' ? 'Not Provided' : printData.grade;

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${grade}`, 70, 70);

        console.log(printData.school);

        school = printData.school === '<i>Not Provided</i>' ? 'Not Provided' : printData.school;

        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`School : `, 20, 75);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${school}`, 70, 75);

        console.log(printData.dependants);

        dependants = printData.dependants == null ? 'Not Provided' : printData.dependants;
        
        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Dependant(s) : `, 20, 80);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${dependants}`, 70, 80);

        console.log(printData.projects);

        projects = printData.projects == null ? 'Not Provided' : printData.projects;

        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Project(s) : `, 20, 85);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${projects}`, 70, 85);



        doc.setFontSize(11);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Disbursed Donation Summary `, 20, 95);

        // Define the table columns and data
        const columns = ["Reciept ID", "Amount","Purpose", "Project", "Date"];
        const rows = data.map(item => [item.ID, item.amount, item.purpose, item.name, item.date]);

        // Generate the table
        doc.autoTable({
            head: [columns],
            body: rows,
            startY: 100, // Set the start position for the table
            pageBreak: 'auto',
            theme: 'striped', // Add a striped table style (optional)
            headStyles: {
                fillColor: [41, 128, 185],
                textColor: [255, 255, 255]
            }, // Table header styles
            margin: {
                top: 10
            }, // Margin around the table
        });



        // Output the PDF
        doc.save(`DonationDisbursed_${from}To${to}_${printData.firstName}${printData.lastName}.pdf`);

        const btn = document.getElementById('down-btn');
        btn.style.backgroundColor = '#4EB220';
        btn.innerHTML = '&#128210; PDF Downloaded';

        setTimeout(() => {
            btn.disabled = false;
            btn.style.backgroundColor = 'rgb(63 41 16)';
            btn.innerHTML = '&#128195; Download as PDF';
            document.getElementById('from-date').value = '';
            document.getElementById('to-date').value = '';
        }, 3000)


    }

    
        </script>

</body>


</html>