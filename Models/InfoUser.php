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
            <div class="banner view-banner">
                <div class="user">
                    <h4 id="name">...</h4>
                    <h6 id="role">...</h6>
                </div>
                <div onclick="closeView()" class='close'>Close</div>
            </div>

            <div class="top" id="project-info">
                <div class="infoRow">
                    <div class="infoTitle">
                        Contact Number
                    </div>
                    <div class="info" id="pm-info-contact">
                        ...
                    </div>
                </div>
                <hr class="line">
                <div class="infoRow">
                    <div class="infoTitle">
                        Email
                    </div>
                    <div class="info" id="pm-info-email">
                        ...
                    </div>
                </div>
                <hr class="line">
                <div class="infoRow">
                    <div class="infoTitle">
                        Projects
                    </div>
                    <div class="info" id="pm-info-project">

                    </div>
                </div>
                <hr class="line">
                <div class="infoRow">
                    <div class="infoTitle">
                        Donors
                    </div>
                    <div class="info" id="pm-info-donor">

                    </div>
                </div>
                <hr class="line">
            </div>

            <div class="top" id="donor-info">
                <div class="infoRow">
                    <div class="infoTitle">
                        Contact Number
                    </div>
                    <div class="info" id="donor-info-contact">

                    </div>
                </div>
                <hr class="line">
                <div class="infoRow">
                    <div class="infoTitle">
                        Email
                    </div>
                    <div class="info" id="donor-info-email">

                    </div>
                </div>
                <hr class="line">
                <div class="infoRow">
                    <div class="infoTitle">
                        Date of Birth
                    </div>
                    <div class="info" id="donor-info-dob">

                    </div>
                </div>
                <hr class="line">
                <div class="infoRow">
                    <div class="infoTitle">
                        Total Donated
                    </div>
                    <div class="info" id="donor-info-amount">

                    </div>
                </div>
                <hr class="line">
                <div class="infoRow">
                    <div class="infoTitle">
                        Balance
                    </div>
                    <div style="color: green;" class="info" id="donor-info-bal">

                    </div>
                </div>
                <hr class="line">
                <div class="infoRow">
                    <div class="infoTitle">
                        Assigned Project Managers
                    </div>
                    <div class="info" id="donor-info-pm">

                    </div>
                </div>
                <hr class="line">

                <div class="down-container">
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
                        <button id="down-btn" style="background-color: rgb(85 40 40);" onclick="downloadPDF()" class='down-btn'>&#128195; Download as PDF</button>


                    </div>
                    <div>
                        <small id="date-warning" style="display: none; font-family:'Lato', serif; color: red; text-shadow: 0 0 10px #cd5656;">Select Appropriate range of dates</small>
                    </div>
                </div>

            </div>
        </div>
    </div>


</body>


</html>

<script>
    let printData;

    function userMoreInfo(ID, role) {
        var xhr = new XMLHttpRequest();

        if (role === 'project manager') {
            xhr.open('GET', '/Controllers/GetMoreInfo.php?ID=' + ID + '&type=' + encodeURIComponent('user') + '&role=' + encodeURIComponent('project manager'), true);


            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    const {
                        data
                    } = JSON.parse(xhr.responseText);
                    // //console.log(data);

                    document.getElementById('name').textContent = data.firstname + ' ' + data.lastname;
                    document.getElementById('role').textContent = data.role;
                    document.getElementById('pm-info-contact').textContent = data.contactno;
                    document.getElementById('pm-info-email').textContent = data.email;

                    const prContainer = document.getElementById('pm-info-project');
                    prContainer.innerHTML = ""
                    if (data.projects) {

                        const prArray = data.projects.split(', ');
                        prArray.forEach(element => {
                            const div = document.createElement('div');
                            div.innerHTML = '&#10294; ' + element;

                            prContainer.appendChild(div);
                        });
                    } else {
                        prContainer.innerHTML = '<i>Not Assigned</i>'
                    }

                    const donContainer = document.getElementById('pm-info-donor');
                    donContainer.innerHTML = ""
                    if (data.donors) {

                        const donArray = data.donors.split(', ');
                        donArray.forEach(element => {
                            const div = document.createElement('div');
                            div.innerHTML = '&#10294; ' + element;

                            donContainer.appendChild(div);
                        });
                    } else {
                        donContainer.innerHTML = '<i>Not Assigned</i>'
                    }

                    ViewSetTop();






                }
            };
        } else if (role === 'donor') {
            xhr.open('GET', '/Controllers/GetMoreInfo.php?ID=' + ID + '&type=' + encodeURIComponent('user') + '&role=' + encodeURIComponent('donor'), true);


            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    const {
                        data
                    } = JSON.parse(xhr.responseText);
                    // //console.log(data);
                    printData = data;
                    // console.log(printData);


                    document.getElementById('name').textContent = data.firstname + ' ' + data.lastname;
                    document.getElementById('role').textContent = data.role;
                    document.getElementById('donor-info-contact').textContent = data.contactno;
                    document.getElementById('donor-info-email').textContent = data.email;
                    document.getElementById('donor-info-dob').innerHTML = data.dob;
                    document.getElementById('donor-info-amount').textContent = 'RS ' + data.amount;
                    document.getElementById('donor-info-bal').textContent = 'RS ' + (data.amount - data.spentamount);

                    const prContainer = document.getElementById('donor-info-pm');
                    prContainer.innerHTML = ""
                    if (data.mgrs) {

                        const prArray = data.mgrs.split(', ');
                        prArray.forEach(element => {
                            const div = document.createElement('div');
                            div.innerHTML = '&#10294; ' + element;

                            prContainer.appendChild(div);
                        });
                    } else {
                        prContainer.innerHTML = '<i>Not Assigned</i>'
                    }




                }
            };
        }

        xhr.send();
    }

    function ViewSetTop() {
        //console.log('Serting top');

        const banner = document.querySelector('.view-banner');
        const top = document.querySelectorAll('.top');
        const div = document.querySelector('.edit-div');


        const bannerHeight = banner.offsetHeight;
        // console.log(bannerHeight);
        // alert(banner.offsetWidth);

        // if(banner.offsetWidth < 900) {
        //      top.forEach((el) => {
        //     el.style.top = `calc(${bannerHeight}px + 35px)`;
        // })

        // }else {
        //       top.forEach((el) => {
        //     el.style.top = `calc(${bannerHeight}px + 10px)`;
        // })

        // }



        // div.style.height = `calc(100vh - ${bannerHeight}px)`;
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


        const param = 'type=donor&from=' + fromDate.value + '&to=' + toDate.value + '&ID=' + printData.ID;
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
        doc.text(`Donation Received | ${printData.firstname} ${printData.lastname}`, 20, 20);

        doc.setFontSize(12);
        doc.setTextColor('rgb(168, 167, 167)');
        doc.setFont('Helvetica', 'bold');
        doc.text(`From: ${from}    To: ${to}`, 20, 30);
        // doc.text('Donation Received | CVHTH', 20, 20);

        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Donor : `, 20, 40);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${printData.firstname} ${printData.lastname} (${printData.ID})`, 70, 40);

        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Email : `, 20, 45);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${printData.email}`, 70, 45);


        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Contact Number : `, 20, 50);

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${printData.contactno}`, 70, 50);

        doc.setFontSize(10);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Date of birth : `, 20, 55);

        dob = printData.dob === '<i>Not provided</i>' ? 'Not Provided' : printData.dob;

        doc.setFontSize(10);
        doc.setTextColor('rgb(97, 96, 96)');
        doc.setFont('Times', 'normal');
        doc.text(`${dob}`, 70, 55);


        doc.setFontSize(11);
        doc.setTextColor('black');
        doc.setFont('Times', 'bold');
        doc.text(`Donation Summary `, 20, 65);

        // Define the table columns and data
        const columns = ["Reciept ID", "Donor Name", "Amount", "Date"];
        const rows = data.map(item => [item.ID, printData.firstname + ' ' + printData.lastname, item.amount, item.date]);

        // Generate the table
        doc.autoTable({
            head: [columns],
            body: rows,
            startY: 70, // Set the start position for the table
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
        doc.save(`DonationReceived_${from}To${to}_${printData.firstname}${printData.lastname}.pdf`);

        const btn = document.getElementById('down-btn');
        btn.style.backgroundColor = '#4EB220';
        btn.innerHTML = '&#128210; PDF Downloaded';

        setTimeout(() => {
            btn.disabled = false;
            btn.style.backgroundColor = 'rgb(85 40 40)';
            btn.innerHTML = '&#128195; Download as PDF';
            document.getElementById('from-date').value = '';
            document.getElementById('to-date').value = '';
        }, 3000)


    }
</script>