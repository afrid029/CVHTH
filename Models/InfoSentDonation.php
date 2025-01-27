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
                    <h4 id="don-amount"></h4>
                    <h6 id="don-id"></h6>
                </div>
                <div onclick="closeView()" class='close'>Close</div>
            </div>

            <div  id="don-info">
                <div class="infoRow">
                    <div class="infoTitle">
                        Beneficiary
                    </div>
                    <div style="color: #338A16; font-weight: 700" class="info" id="ben-name">

                    </div>
                </div>
                <hr class="line">


                <div class="infoRow">
                    <div class="infoTitle">
                        Donor
                    </div>
                    <div class="info" id="don-name">
                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        Donated Date
                    </div>
                    <div class="info" id="don-date">
                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        Purpose
                    </div>
                    <div class="info" id="don-purpose">
                    </div>
                </div>
                <hr class="line">

                <div class="infoRow">
                    <div class="infoTitle">
                        Project
                    </div>
                    <div class="info" id="don-project">
                    </div>
                </div>
                <hr class="line">

                <div id="view-preview-container" style="display: flex;gap: 5px; flex-wrap:wrap; margin-top: 10px;margin-bottom: 20px; margin-left: 10px;"></div>

                <!-- <img src="/Assets/Images/info.png" alt=""> -->
            </div>

        </div>
        </div>


        <script>
            function sentDonationMoreInfo(ID, role) {
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

                        document.getElementById('don-amount').textContent = 'Amount (Rs) : ' + data.amount;
                        document.getElementById('don-id').textContent = 'Reciept ID : ' + data.ID;
                        document.getElementById('ben-name').textContent = data.beneficent;
                        document.getElementById('don-name').textContent = data.donor;
                        document.getElementById('don-date').textContent = data.date;
                        document.getElementById('don-purpose').textContent = data.purpose;
                        document.getElementById('don-project').textContent = data.name;
                        ViewSetTop();

                        viewPreviewImages(data.evidence);

                    }
                };


                xhr.send();
            }

            function ViewSetTop() {
                console.log('Serting top');

                const banner = document.querySelector('.view-banner');
                const top = document.querySelector('#don-info');
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
                    imgElement.alt = 'Image not available';
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