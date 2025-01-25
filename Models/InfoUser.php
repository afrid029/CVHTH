<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Assets/CSS/MoreInfo.css">


</head>

<body>
    <div class="modal-overlay" id="viewModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="banner view-banner">
                <div class="user">
                    <h4 id="name">Arun Raja</h4>
                    <h6 id="role">Project Manager</h6>
                </div>
                <div onclick="closeView()" class='close'>Close</div>
            </div>

            <div class="top" id="project-info">
                <div class="infoRow">
                    <div class="infoTitle">
                        Contact Number
                    </div>
                    <div class="info" id="pm-info-contact">
                        0778363530
                    </div>
                </div>
                <hr class="line">
                <div class="infoRow">
                    <div class="infoTitle">
                        Email
                    </div>
                    <div class="info" id="pm-info-email">
                        afrid@gmail.com
                    </div>
                </div>
                <hr class="line">
                <div class="infoRow">
                    <div class="infoTitle">
                        Projects
                    </div>
                    <div class="info" id="pm-info-project">
                        <div>&#10294; Disabled</div>
                        <div>&#10294; Orphan</div>
                        <div>&#10294; Old Women</div>
                        <div>&#10294; Child</div>
                    </div>
                </div>
                <hr class="line">
                <div class="infoRow">
                    <div class="infoTitle">
                        Donors
                    </div>
                    <div class="info" id="pm-info-donor">
                        <div>&#10294; Kumar</div>
                        <div>&#10294; Karnan</div>
                        <div>&#10294; Sayoorn</div>
                        <div>&#10294; Afrid</div>
                        <div>&#10294; Kumar</div>
                        <div>&#10294; Karnan</div>
                        <div>&#10294; Sayoorn</div>
                        <div>&#10294; Afrid</div>
                        <div>&#10294; Kumar</div>
                        <div>&#10294; sdsadas.d;as, a[dkas[ sa;ld,asKarnan</div>
                        <div>&#10294; Sayoorn</div>
                        <div>&#10294; Afrid</div>
                        <div>&#10294; Kumar</div>
                        <div>&#10294; Karnan</div>
                        <div>&#10294; Sayoorn</div>
                        <div>&#10294; Afrid</div>
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

            </div>
        </div>
    </div>


</body>


</html>

<script>
            function userMoreInfo(ID, role) {
                var xhr = new XMLHttpRequest();

                if (role === 'project manager') {
                    xhr.open('GET', '/Controllers/GetMoreInfo.php?ID=' + ID + '&type=' + encodeURIComponent('user') + '&role=' + encodeURIComponent('project manager'), true);
                    // document.getElementById('loading-spinner').style.display = 'block';
                    // const onload = document.getElementById('onrowload');
                    // onload.classList.add('onrowload');

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // document.getElementById('loading-spinner').style.display = 'none';
                            // // document.getElementById('onrowload').style.display = 'none';
                            // onload.classList.remove('onrowload');
                            const {
                                data
                            } = JSON.parse(xhr.responseText);
                            // console.log(data);

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






                        }
                    };
                } else if (role === 'donor') {
                    xhr.open('GET', '/Controllers/GetMoreInfo.php?ID=' + ID + '&type=' + encodeURIComponent('user') + '&role=' + encodeURIComponent('donor'), true);
                    // document.getElementById('loading-spinner').style.display = 'block';
                    // const onload = document.getElementById('onrowload');
                    // onload.classList.add('onrowload');

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // document.getElementById('loading-spinner').style.display = 'none';
                            // // document.getElementById('onrowload').style.display = 'none';
                            // onload.classList.remove('onrowload');
                            const {
                                data
                            } = JSON.parse(xhr.responseText);
                            // console.log(data);

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
                console.log('Serting top');

                const banner = document.querySelector('.view-banner');
                const top = document.querySelectorAll('.top');
                const div = document.querySelector('.edit-div');


                const bannerHeight = banner.offsetHeight;
                // console.log(bannerHeight);

                top.forEach((el) => {
                    el.style.top = `calc(${bannerHeight}px + 10px)`;
                })


                // div.style.height = `calc(100vh - ${bannerHeight}px)`;
            }
        </script>