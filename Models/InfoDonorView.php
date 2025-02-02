<html>

<head>
    <meta charset="UTF-8">
    <link href="Assets/CSS/MoreInfo.css" rel="stylesheet" />
    <link rel="stylesheet" href="Assets/CSS/AddSentDonation.css">


</head>

<body>
    <div class="modal-overlay" id="viewModel">
        <div class="modal-content" onclick="event.stopPropagation()">
        <div id="popupImage" style="position: fixed; height: 100vh; display:none; background-color: #000000d4; justify-content: center; width: 100vw; z-index: 910">
                
                <img id="popupSrc" style="object-fit: contain; width: 100vw"  alt="">
                <div onclick="closePop()" style="position: absolute; padding:10px; border-radius: 10px; box-shadow: 0 0 4px white; top: 2vh; right:2vw; cursor:pointer; background-color: white">Close</div>
            </div>
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

                <div id="view-preview-container" style="display: flex; justify-content: center; gap: 5px; flex-wrap:wrap; margin-top: 10px;margin-bottom: 20px; margin-left: 10px;"></div>

                <!-- <img src="/Assets/Images/info.png" alt=""> -->
            </div>

        </div>
        </div>


        <script>
            function sentDonationMoreInfo(ID, role) {
                var xhr = new XMLHttpRequest();


                xhr.open('GET', '/Controllers/GetMoreInfo.php?ID=' + ID + '&type=' + encodeURIComponent(role), true);
               

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        
                        const {
                            data
                        } = JSON.parse(xhr.responseText);
                        // //console.log(data);

                        document.getElementById('don-amount').textContent = 'Amount (Rs) : ' + data.amount;
                        document.getElementById('don-id').textContent = 'Reciept ID : ' + data.ID;
                        document.getElementById('ben-name').innerHTML = data.beneficent ? data.beneficent : '<i>Deleted Beneficiary</i>';
                        document.getElementById('don-name').innerHTML = data.donor ? data.donor : '<i>Deleted Donor</i>' ;
                        document.getElementById('don-project').innerHTML = data.name ? data.name :'<i>Deleted Project</i>' ;
                        document.getElementById('don-date').textContent = data.date;
                        document.getElementById('don-purpose').textContent = data.purpose;
                        
                        ViewSetTop();

                        viewPreviewImages(data.evidence);

                    }
                };


                xhr.send();
            }

            function ViewSetTop() {
                //console.log('Serting top');

                const banner = document.querySelector('.view-banner');
                const top = document.querySelector('#don-info');
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
                    imgElement.alt = 'Image not available';
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
        </script>

</body>


</html>