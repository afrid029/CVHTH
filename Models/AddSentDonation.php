<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/AddSentDonation.css">

    </script>
</head>



<body>

    <div class="modal-overlay" id="addModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <!-- <div onclick="handleAdd(false)" class='close'>Close</div> -->
            <div class="banner">
                Disburse Fund
                <div onclick="handleAdd(false)" class='close'>Close</div>
            </div>

            <form id="sentdonation" method="post" oninput="validateForm()"  enctype="multipart/form-data">
                <!-- <form action="/add-sentdonation" method="post"> -->
                <div class="div"> </div>
                <div class="Form">

                    <!-- Enter Amount -->
                    <div class="FormRow">

                        <input
                            type="number"
                            name="amount"
                            placeholder="Serving Amount (Rs)"
                            min="1"
                            id="select-amount"
                            required />

                        <small class="small">Amount is required</small>
                    </div>
                    <!-- Select Donor -->
                    <div class="FormRow">

                        <input type="text" name="donor" id="select-donor-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="select-donor" placeholder="Select Donor" onclick="openSelect('dropdown-container-donor',true)" readonly required>

                        <div class="dropdown-container" id="dropdown-container-donor">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 80%" type="text" id="donorSearchkey" placeholder="Search Donors">
                            </div>
                            <div class="dropdown-list" id="dropdown-list-donor">

                            </div>

                        </div>

                        <small class="small">Donor is required</small>
                        <small ID='not-enough' style="display: none; color: #765309" class="small">Donor has not sufficient balance.</small>

                    </div>

                    <!-- Select Date -->
                    <div class="FormRow">
                        <small style="color: gray; display: flex; width: 100%; font-size: 12px; margin-bottom: 5px; font-family: Lato, serif">Donated Date</small>
                        <input type="date" id="select-date" name="date" required>
                        <small class="small">Date is required</small>
                    </div>

                    <!-- Select Project Name -->
                    <div class="FormRow">

                        <input type="text" name="project" id="select-project-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="select-project" placeholder="Select Project" onclick="openSelect('dropdown-container-project',true)" readonly required>

                        <div class="dropdown-container" id="dropdown-container-project">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 80%" type="text" id="projectSearchkey" placeholder="Search Project">
                            </div>
                            <div class="dropdown-list" id="dropdown-list-project">

                            </div>

                        </div>

                        <small class="small">Project is required</small>

                    </div>

                    <!-- Select Beneficent Name -->
                    <div style="display: none;" id="select-beneficent-cont" class="FormRow">

                        <input type="text" name="beneficent" id="select-beneficent-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="select-beneficent" placeholder="Select Beneficiary" onclick="openSelect('dropdown-container-beneficent',true)" readonly required>

                        <div class="dropdown-container" id="dropdown-container-beneficent">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 80%" type="text" id="beneficentSearchkey" placeholder="Search Beneficiary">
                            </div>
                            <div class="dropdown-list" id="dropdown-list-beneficent">

                            </div>

                        </div>

                        <small class="small">Beneficiary is required</small>

                    </div>




                    <!-- Enter Purpose -->
                    <div class="FormRow">

                        <textarea
                            name="purpose"
                            placeholder="Purpose of the funding"
                            id="select-purpose"
                            maxlength="100"
                            required></textarea>

                        <small class="small">Purpose is required</small>
                    </div>


                    <!-- Images -->
                    <div class="FormRow">
                        <small style="color: gray; display: flex; width: 100%; font-size: 12px; margin-bottom: 5px; font-family: Lato, serif">Attach Document(s)</small>
                        <input type="file" accept="image/jpeg, image/png, image/gif, image/jpg" id="select-image" name="image[]" placeholder="Upload Images" hidden multiple>
                        <button class="image-btn" type="button" onclick="openImage()">select images</button>
                        <small class="small">Documents required</small>
                        <div id="preview-container" style="display: flex; justify-content: center; gap: 5px; flex-wrap:wrap; margin-top: 10px;"></div>
                    </div>

                    <script>
                        let allFiles = []; 

                        function openImage(){
                        document.getElementById('select-image').click();
                       }
                       
                        function PreviewImages(event) {
                            const newFiles = Array.from(event.target.files);
                           
                            if (newFiles.length + allFiles.length > 6) {
                                alert('You can select a maximum of 6 images.');
                                event.target.value = '';
                                validateForm() // Clear the input (prevents submitting the 7th file)
                                return;
                            }

                            allFiles = [...allFiles, ...newFiles];

                                   
                            event.target.value = '';
                            displayImages();
                            validateForm();

            

                        }

                        function displayImages() {
                            const previewContainer = document.getElementById('preview-container');
                            previewContainer.innerHTML = ''; // Clear the container before showing new images
                            for (let i = 0; i < allFiles.length; i++) {
                                const file = allFiles[i];

                                // Check if the selected file is an image
                                if (file.type.startsWith('image/')) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {

                                        const divEl = document.createElement('div');
                                        divEl.style.width = '100px';
                                        divEl.style.height = 'auto';
                                        divEl.style.position = 'relative';
                                        divEl.style.display = 'flex'
                                        divEl.style.flexDirection = 'column'
                                        divEl.style.gap = '5px'
                                        divEl.style.backgroundColor = '#CBCBCB'
                                        divEl.style.borderRadius = '10px'

                                        const imgElement = document.createElement('img');
                                        imgElement.src = e.target.result;
                                        imgElement.style.borderRadius = '10px'
                                        imgElement.style.height = '100px';
                                        imgElement.style.width = '100px'; // Optional: resize the image for preview
                                        imgElement.style.objectFit = 'cover'; // Optional: resize the image for preview
                                        // imgElement.style.margin = '10px';

                                        const delButton = document.createElement('button');
                                        delButton.textContent = 'Delete'
                                        delButton.style.position = 'relative';
                                        delButton.style.backgroundColor = '#670e0e';
                                        delButton.style.border = 'transparent';
                                        delButton.style.borderRadius = '10px';
                                        delButton.style.padding = '5px';
                                        delButton.style.color = 'white';
                                        delButton.style.cursor = 'pointer';

                                        delButton.type = 'button';
                                        delButton.onclick = function(){
                                            removeImage(i);
                                        }
                                        
                                        // Optional: add margin between images

                                        divEl.appendChild(imgElement)
                                        divEl.appendChild(delButton)
                                        previewContainer.appendChild(divEl);
                                    };
                                    reader.readAsDataURL(file); // Read the file as a data URL for previewing
      
                                } else {
                                    alert('Please select only image files.');
                                }
                            }
                        }

                        function removeImage(index) {
                            // Remove the file from the allFiles array
                            allFiles.splice(index, 1);
                            
                            // Re-render the file list
                            displayImages();
                            validateForm();
                        }


                    </script>

                    <div class="button">
                        <button
                            type="submit"
                            id="submit"
                            name="submit"
                            disabled="true"
                            class="submit"> Disburse Amount
                        </button>

                        <button
                            style="display: none;"
                            id="submiting"
                            disabled="true"
                            class="submit"> Saving...
                        </button>
                    </div>

                </div>


            </form>
        </div>
    </div>

</body>

</html>


<script>
    let donorResponse;
    let project;
    let beneficent;
    let selectedBene;

    const today = new Date();
    const localDate = today.toLocaleDateString('en-CA');
    // Set the max attribute to today's date
    document.getElementById('select-date').setAttribute('max', localDate);


    function setTop() {

        const banner = document.querySelector('.banner');
        const form = document.querySelector('.form');
        const div = document.querySelector('.div');


        const bannerHeight = banner.offsetHeight;
        // //console.log(bannerHeight);

        // form.style.top = `calc(${bannerHeight}px + 10px)`;
        // div.style.height = `calc(100vh - ${bannerHeight}px)`;
    }

    function openSelect(ID, value) {
        const select = document.getElementById(ID);

        if (!value) {
            select.style.display = 'none';
        } else {
            select.style.display = 'flex';
        }
    }

    function loadDonors() {
        var xhr = new XMLHttpRequest();

        <?php
        if ($_SESSION['role'] === 'project manager') {
            $prjID = $_SESSION['ID'];
            echo "xhr.open('GET', '/Controllers/GetAllUsers.php?role=donor&pmID=' + '$prjID', true)";
        } else {
            echo "xhr.open('GET', '/Controllers/GetAllUsers.php?role=donor', true)";
        }

        ?>

       

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
             
                donorResponse = JSON.parse(xhr.responseText);
                // //console.log(response.data);

                // const listContainer = document.getElementById('dropdown-list-donor');
                const search = document.getElementById('donorSearchkey');
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', donorSearchListener)

                loadSearchOptionsForDonor(donorResponse.data)

                
            }
        };

        xhr.send();
    }

    function donorSearchListener(event) {

        const key = event.target.value;
        if (key == '') {
            loadSearchOptionsForDonor(donorResponse.data)
        } else {
            let copyData = donorResponse.data.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
            loadSearchOptionsForDonor(copyData)


        }
    }

    function loadSearchOptionsForDonor(data) {


        const listContainer = document.getElementById('dropdown-list-donor');
        listContainer.innerHTML = ""

        data.forEach(element => {
            // //console.log(element);
            const option = document.createElement('div')
            const hr = document.createElement('hr')
            hr.setAttribute('class', 'line')

            option.setAttribute('class', 'dropdown-option');
            option.setAttribute('value', element.ID);
            option.textContent = element.firstname + " " + element.lastname;

            const small = document.createElement('div');
            small.setAttribute('class', 'balance')
            small.textContent = 'Balance (Rs) : ' + element.balance;
            option.appendChild(small);

            listContainer.appendChild(option);
            listContainer.appendChild(hr)


        });

        listContainer.addEventListener('click', selectDonors)

    }

    function selectDonors(event) {

        const selectDonor = document.getElementById('select-donor');
        const selectDonorValue = document.getElementById('select-donor-value');

        if (event.target.classList.contains('dropdown-option')) {
            const name = event.target.textContent.split('Balance')
            selectDonor.setAttribute('value', name[0])
            selectDonorValue.setAttribute('value', event.target.getAttribute('value'))

            openSelect('dropdown-container-donor', false);
            validateForm();

            // //console.log(event.target.getAttribute('value'), event.target.textContent);
        }
    }

    function loadProjBene() {
        var xhr = new XMLHttpRequest();

        <?php
        if ($_SESSION['role'] === 'project manager') {
            $prjID = $_SESSION['ID'];
            echo "xhr.open('GET', '/Controllers/GetProjectAndBeneficents.php?pmID=' + '$prjID', true)";
        } else {
            echo "xhr.open('GET', '/Controllers/GetProjectAndBeneficents.php', true)";
        }

        ?>

    

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                
                var result = JSON.parse(xhr.responseText);
                // //console.log(result);
                project = result.data1;
                beneficent = result.data;

                // const listContainer = document.getElementById('dropdown-list-donor');
                const search = document.getElementById('projectSearchkey');
                const search1 = document.getElementById('beneficentSearchkey')
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', projectSearchListener)
                search1.addEventListener('input', BeneSearchListener)

                loadSearchOptionsForProject(project)

            }
        };

        xhr.send();
    }

    function projectSearchListener(event) {
        const key = event.target.value;
        if (key == '') {
            loadSearchOptionsForProject(project)
        } else {
            let copyData = project.filter((ele) =>
                (ele.name).toUpperCase().includes(key.toUpperCase()));
            loadSearchOptionsForProject(copyData)


        }
    }

    function loadSearchOptionsForProject(data) {

        const listContainer = document.getElementById('dropdown-list-project');
        listContainer.innerHTML = ""

        // //console.log(data);


        data.forEach(element => {
            // //console.log(element);
            const option = document.createElement('div')
            const hr = document.createElement('hr')
            hr.setAttribute('class', 'line')

            option.setAttribute('class', 'dropdown-option');
            option.setAttribute('value', element.ID);
            option.textContent = element.name;

            listContainer.appendChild(option);
            listContainer.appendChild(hr)


        });

        listContainer.addEventListener('click', selectProjects)
    }

    function selectProjects(event) {

        const selectDonor = document.getElementById('select-project');
        const selectDonorValue = document.getElementById('select-project-value');

        if (event.target.classList.contains('dropdown-option')) {

            const value = event.target.getAttribute('value');
            const textContent = event.target.textContent
            selectDonor.setAttribute('value', textContent)
            selectDonorValue.setAttribute('value', value)

            openSelect('dropdown-container-project', false);

            showBeneficents(value);

        }

    }

    function showBeneficents(value) {
        const beneCont = document.getElementById('select-beneficent-cont');
        beneCont.style.display = 'flex';

        document.getElementById('select-beneficent').removeAttribute('value');
        document.getElementById('select-beneficent-value').removeAttribute('value');
        validateForm();

        selectedBene = beneficent.filter((el) => {
            // //console.log(el, value);

            return el.project_id === value
        })

        // //console.log(selectedBene);


        loadSearchOptionsForBene(selectedBene);

    }

    function BeneSearchListener(event) {
        const key = event.target.value;
        if (key == '') {
            loadSearchOptionsForBene(selectedBene)
        } else {
            let copyData = selectedBene.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
            loadSearchOptionsForBene(copyData)


        }
    }

    function loadSearchOptionsForBene(benes) {
        const listContainer = document.getElementById('dropdown-list-beneficent');
        listContainer.innerHTML = ""

        benes.forEach((ele) => {

            const option = document.createElement('div')
            const hr = document.createElement('hr')
            hr.setAttribute('class', 'line')

            option.setAttribute('class', 'dropdown-option');
            option.setAttribute('value', ele.ID);
            option.textContent = ele.firstname + " " + ele.lastname;

            listContainer.appendChild(option);
            listContainer.appendChild(hr)

        })

        listContainer.addEventListener('click', selectBeneficents)
    }

    function selectBeneficents(event) {
        const selectDonor = document.getElementById('select-beneficent');
        const selectDonorValue = document.getElementById('select-beneficent-value');

        if (event.target.classList.contains('dropdown-option')) {

            const value = event.target.getAttribute('value');
            const textContent = event.target.textContent
            selectDonor.setAttribute('value', textContent)
            selectDonorValue.setAttribute('value', value)

            validateForm();
            openSelect('dropdown-container-beneficent', false);

        }

    }

    function validateForm() {
        const donor = document.getElementById('select-donor-value').value;
        const date = document.getElementById('select-date').value.length > 0;
        const project = document.getElementById('select-project-value').value.length > 0;
        const beneficent = document.getElementById('select-beneficent-value').value.length > 0;
        const amount = document.getElementById('select-amount').value;
        const purpose = document.getElementById('select-purpose').value.length > 0;
        const selectedImage = document.getElementById('select-image').value.length > 0;
        const button = document.getElementById('submit');

        if (donor.length > 0 && amount.length > 0) {
            const selectedDonor = donorResponse.data.filter((ele) =>
                (ele.ID === donor));
            //console.log(selectedDonor);

            if (parseInt(selectedDonor[0].balance) < amount) {


                document.getElementById('not-enough').style.display = 'flex';
                document.getElementById('select-donor-value').removeAttribute('value');
                document.getElementById('select-donor').removeAttribute('value');
                // validateForm();

            } else {
                document.getElementById('not-enough').style.display = 'none';
                // validateForm();
            }
        }

        const donor2 = document.getElementById('select-donor-value').value;

        if (donor2.length > 0 && date && project && beneficent && amount.length > 0 && purpose && allFiles.length > 0) {
            button.disabled = false;
        } else {
            button.disabled = true;
        }
    }

    document.getElementById('sentdonation').addEventListener('submit', function(event){
        let button = document.getElementById('submit');
        let button2 = document.getElementById('submiting');
        button.style.display = 'none';
        button2.style.display = 'block';

        event.preventDefault();

        const formData = new FormData;

        allFiles.forEach(file => {
            formData.append('image[]', file);
        });

       const amount = document.getElementById('select-amount').value;
       const donor = document.getElementById('select-donor-value').value;
       const date = document.getElementById('select-date').value;
       const project = document.getElementById('select-project-value').value;
       const beneficent = document.getElementById('select-beneficent-value').value;
       const purpose = document.getElementById('select-purpose').value;

        formData.append('amount', amount);
        formData.append('donor', donor);
        formData.append('date', date);
        formData.append('project',project);
        formData.append('beneficent', beneficent);
        formData.append('purpose',purpose);
        formData.append('submit',true);

        // console.log(formData)
        

        const xhr = new XMLHttpRequest();
    xhr.open('POST', '/add-sentdonation', true);
    xhr.onload = function() {
        if (xhr.status == 200) {
            const data = JSON.parse(xhr.responseText)
            console.log(data);
            
            window.location.href = data.redirect;
            
        } else {
            console.error('Error submitting form ',xhr.statusText);
        }
    };
    
    xhr.send(formData);

// 
    })
</script>