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


            </div>

        </div>
        </div>


        <script>
            function beneficentMoreInfo(ID, role) {
                var xhr = new XMLHttpRequest();


                xhr.open('GET', '/Controllers/GetMoreInfo.php?ID=' + ID + '&type=' + encodeURIComponent(role), true);
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
                        console.log(data);

                        document.getElementById('ben-name').textContent = data.firstName + ' ' + data.lastName;
                        document.getElementById('ben-id').textContent = 'Benificent ID : ' + data.ID;
                        document.getElementById('ben-amount').textContent ='Benefited Amount (Rs) : '+ data.sent;
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




                        ViewSetTop();

                        viewPreviewImages(data.images);

                    }
                };


                xhr.send();
            }

            function ViewSetTop() {
                console.log('Serting top');

                const banner = document.querySelector('.view-banner');
                const top = document.querySelector('#ben-info');
                const div = document.querySelector('.edit-div');


                const bannerHeight = banner.offsetHeight;
                // console.log(bannerHeight);

                top.style.top = `calc(${bannerHeight}px + 10px)`;



                // div.style.height = `calc(100vh - ${bannerHeight}px)`;
            }

            function viewPreviewImages(data) {
                const imgContainer = document.getElementById('view-preview-container');
                imgContainer.innerHTML = ""

                const imgArray = data.split(', ');
                console.log(imgArray);
                

                imgArray.forEach((imgSrc) => {
                    console.log(imgSrc);
                    
                 
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
                    // imgElement.style.margin = '10px';

                    // Optional: add margin between images

                    console.log(imgElement);
                    

                    divEl.appendChild(imgElement)
                    imgContainer.appendChild(divEl);
                
                })
                // reader.readAsDataURL(file); // Read the file as a data URL for previewing

            }

    
        </script>

</body>


</html>