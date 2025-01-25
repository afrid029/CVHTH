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
                    <h4 id="prj-name"></h4>
                    <h6 id="prj-id"></h6>
                </div>
                <div onclick="closeView()" class='close'>Close</div>
            </div>

            <div id="prj-info">
                <div class="infoRow">
                    <div class="infoTitle">
                        Description
                    </div>
                    <div class="info" id="prj-desc">
                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        Manager(s)
                    </div>
                    <div style="color: #B5A645; font-weight: 700"  class="info" id="prj-pm">

                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        Beneficiary
                    </div>
                    <div class="info" id="prj-ben">

                    </div>
                </div>
                <hr class="line">


            </div>

        </div>
        </div>


        <script>
            function projectMoreInfo(ID, role) {
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
                        // console.log(data);

                        document.getElementById('prj-name').textContent = data.name;
                        document.getElementById('prj-id').textContent = 'Project ID : ' + data.ID;
                        document.getElementById('prj-desc').textContent = data.description;

                        const mgrContainer = document.getElementById('prj-pm');
                        mgrContainer.innerHTML = "";

                        if (data.manager) {
                            const pmArray = data.manager.split(', ');
                            pmArray.forEach((pm) => {
                                const div = document.createElement('div');
                                div.innerHTML = '&#10294; ' + pm;
                                mgrContainer.appendChild(div)
                            })
                        }else {
                            mgrContainer.innerHTML = "<i>Not Assigned</i>"
                        }

                        const beneContainer = document.getElementById('prj-ben');
                        beneContainer.innerHTML = "";

                        if (data.beneficent) {
                            const benArray = data.beneficent.split(', ');
                            benArray.forEach((ben) => {
                                const div = document.createElement('div');
                                div.innerHTML = '&#10294; ' + ben;
                                beneContainer.appendChild(div)
                            })
                        }else {
                            beneContainer.innerHTML = "<i>Not Assigned</i>"
                        }




                        ViewSetTop();

                        // viewPreviewImages(data.evidence);

                    }
                };


                xhr.send();
            }

            function ViewSetTop() {
                console.log('Serting top');

                const banner = document.querySelector('.view-banner');
                const top = document.querySelector('#prj-info');
                const div = document.querySelector('.edit-div');


                const bannerHeight = banner.offsetHeight;
                // console.log(bannerHeight);

                top.style.top = `calc(${bannerHeight}px + 10px)`;



                // div.style.height = `calc(100vh - ${bannerHeight}px)`;
            }

    
        </script>

</body>


</html>