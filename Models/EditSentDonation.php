<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/AddSentDonation.css">

    </script>
</head>



<body>

    <div class="modal-overlay" id="editModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <!-- <div onclick="handleAdd(false)" class='close'>Close</div> -->
            <div class="banner edit-banner">
                Edit Served Donation
                <div onclick="closeEdit()" class='close'>Close</div>
            </div>

            <form action="/#" method="post" oninput="validateEditForm()" onsubmit="return submitEditForm()" enctype="multipart/form-data">
            <!-- <form action="/#" method="post"> -->
                <div class="div edit-div"> </div>
                <div class="Form edit-Form">
                    <!-- Select Donor -->
                    <div class="FormRow">

                        <input type="text" name="donor" id="edit-donor-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="edit-donor" placeholder="Select Donor" onclick="editOpenSelect('edit-dropdown-container-donor',true)" readonly required>

                        <div class="dropdown-container edit-dropdown-container" id="edit-dropdown-container-donor">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 80%" type="text" id="editDonorSearchkey" placeholder="Search Donors">
                            </div>
                            <div class="dropdown-list" id="edit-dropdown-list-donor">

                            </div>

                        </div>

                        <small class="small">Donor is required</small>

                    </div>

                    <!-- Select Date -->
                    <div class="FormRow">
                        <small style="color: gray; display: flex; width: 100%; font-size: 12px; margin-bottom: 5px; font-family: Lato, serif">Donated Date</small>
                        <input type="date" id="edit-date" name="date" required>
                        <small class="small">Date is required</small>
                    </div>

                    <!-- Select Project Name -->
                    <div class="FormRow">

                        <input type="text" name="project" id="edit-project-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="edit-project" placeholder="Select Project" onclick="editOpenSelect('edit-dropdown-container-project',true)" readonly required>

                        <div class="dropdown-container edit-dropdown-container" id="edit-dropdown-container-project">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 80%" type="text" id="editProjectSearchkey" placeholder="Search Project">
                            </div>
                            <div class="dropdown-list" id="edit-dropdown-list-project">

                            </div>

                        </div>

                        <small class="small">Project is required</small>

                    </div>

                    <!-- Select Beneficent Name -->
                    <div style="display: none;" id="edit-beneficent-cont" class="FormRow">

                        <input type="text" name="beneficent" id="edit-beneficent-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="edit-beneficent" placeholder="Select Beneficiary" onclick="editOpenSelect('edit-dropdown-container-beneficent',true)" readonly required>

                        <div class="dropdown-container edit-dropdown-container" id="edit-dropdown-container-beneficent">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 80%" type="text" id="editBeneficentSearchkey" placeholder="Search Beneficiary">
                            </div>
                            <div class="dropdown-list" id="edit-dropdown-list-beneficent">

                            </div>

                        </div>

                        <small class="small">Beneficiary is required</small>

                    </div>

                    <!-- Enter Amount -->
                    <div class="FormRow">

                        <input
                            type="number"
                            name="amount"
                            placeholder="Serving Amount (Rs)"
                            min="1"
                            id="edit-amount"
                            required />

                        <small class="small">Amount is required</small>
                    </div>


                    <!-- Enter Purpose -->
                    <div class="FormRow">

                        <textarea
                            name="purpose"
                            placeholder="Purpose of the funding"
                            id="edit-purpose"
                            maxlength="100"
                            required></textarea>

                        <small class="small">Purpose is required</small>
                    </div>

                    
                    <!-- Images -->
                    <!-- <div class="FormRow">
                    <small style="color: gray; display: flex; width: 100%; font-size: 12px; margin-bottom: 5px; font-family: Lato, serif">Attach Document(s)</small>
                        <input type="file" accept="image/jpeg, image/png, image/gif, image/jpg" id="edit-image" name="image" placeholder="Upload Images" required multiple>
                        <small class="small">Documents required</small>
                        <div id="edit-preview-container" style="display: flex;gap: 5px; flex-wrap:wrap; margin-top: 10px;"></div>
                    </div> -->

                    <!-- <script>
                        // document.getElementById('select-image').addEventListener('change', PreviewImages);

                        function editPreviewImages(event) {
                            // console.log(val);

                            
                            const files = event.target.files;
                            const previewContainer = document.getElementById('edit-preview-container');
                            previewContainer.innerHTML = ''; // Clear the container before showing new images

                            if (files.length > 6) {
                                alert('You can select a maximum of 6 images.');
                                event.target.value = ''; // Clear the input (prevents submitting the 7th file)
                                return;
                            }

                            // Loop through the selected files
                            for (let i = 0; i < files.length; i++) {
                                const file = files[i];

                                // Check if the selected file is an image
                                if (file.type.startsWith('image/')) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {

                                        const divEl = document.createElement('div');
                                        divEl.style.width = '100px';
                                        divEl.style.height = '100px';
                                        divEl.style.position = 'relative';
                                        divEl.style.display = 'flex'
                                        divEl.style.gap = '5px'
                                        divEl.style.backgroundColor = '#CBCBCB'
                                        divEl.style.borderRadius = '10px'

                                        const imgElement = document.createElement('img');
                                        imgElement.src = e.target.result;
                                        imgElement.style.width = '100px'; // Optional: resize the image for preview
                                        imgElement.style.objectFit = 'cover'; // Optional: resize the image for preview
                                        // imgElement.style.margin = '10px';
                                        
                                        // Optional: add margin between images

                                        divEl.appendChild(imgElement)
                                        previewContainer.appendChild(divEl);
                                    };
                                    reader.readAsDataURL(file); // Read the file as a data URL for previewing
                                } else {
                                    alert('Please select only image files.');
                                }
                            }
                            
                        }
                    </script> -->

                    <div class="button">
                        <button
                            type="submit"
                            id="edit-submit"
                            name="submit"
                            disabled="true"
                            class="submit"> Update
                        </button>

                        <button
                            style="display: none;"
                            id="edit-submiting"
                            disabled="true"
                            class="submit"> Updating...
                        </button>
                    </div>

                </div>


            </form>
        </div>
    </div>

</body>

</html>


<script>
    let editDonorResponse;
    let editProject;
    let editBeneficent;
    let editSelectedBene;


    function getSingleSentDonation(ID){
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetSingleData.php?ID='+ID+'&type=' + encodeURIComponent('sentdonation'), true);
        // document.getElementById('loading-spinner').style.display = 'block';
        // const onload = document.getElementById('onrowload');
        // onload.classList.add('onrowload');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // document.getElementById('loading-spinner').style.display = 'none';
                // // document.getElementById('onrowload').style.display = 'none';
                // onload.classList.remove('onrowload');
                const {data} = JSON.parse(xhr.responseText);
                console.log(data);

                document.getElementById("edit-donor-value").setAttribute('value', data.Donor_ID);

                console.log(editDonorResponse);
                

                for(const el of editDonorResponse.data){
                    if(el.ID === data.Donor_ID){
                        document.getElementById("edit-donor").setAttribute('value', el.firstname + " " + el.lastname);
                        break;
                    }
                }
                document.getElementById("edit-project-value").setAttribute('value', data.Project_ID);
              
                for(const el of editProject) {
                    if(el.ID === data.Project_ID){
                        document.getElementById("edit-project").setAttribute('value', el.name);
                        currentBeneficents(el.ID);
                        break;
                    }
                }

                document.getElementById("edit-beneficent-value").setAttribute('value', data.Beneficiant_ID);
              
                for(const el of editBeneficent) {
                    if(el.ID === data.Beneficiant_ID){
                        document.getElementById("edit-beneficent").setAttribute('value',  el.firstname + " " + el.lastname);
                        break;
                    }
                }

                document.getElementById("edit-amount").value = data.amount;
                document.getElementById("edit-date").value = data.date;
                document.getElementById("edit-purpose").value = data.purpose;

                validateEditForm();

            }
        };

        xhr.send();
    }

    const editToday = new Date();
    const editLocalDate = editToday.toLocaleDateString('en-CA');
    // Set the max attribute to today's date
    document.getElementById('select-date').setAttribute('max', editLocalDate);


    function editSetTop() {

        const banner = document.querySelector('.edit-banner');
        const form = document.querySelector('.edit-Form');
        const div = document.querySelector('.edit-div');


        const bannerHeight = banner.offsetHeight;
        // console.log(bannerHeight);

        form.style.top = `calc(${bannerHeight}px + 10px)`;
        // div.style.height = `calc(100vh - ${bannerHeight}px)`;
    }

    function editOpenSelect(ID, value) {
        const select = document.getElementById(ID);

        if (!value) {
            select.style.display = 'none';
        } else {
            select.style.display = 'flex';
        }
    }

    function editLoadDonors() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetAllUsers.php?role=donor', true);
        // document.getElementById('loading-spinner').style.display = 'block';
        // const onload = document.getElementById('onrowload');
        // onload.classList.add('onrowload');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // document.getElementById('loading-spinner').style.display = 'none';
                // // document.getElementById('onrowload').style.display = 'none';
                // onload.classList.remove('onrowload');
                editDonorResponse = JSON.parse(xhr.responseText);
                // console.log(response.data);

                // const listContainer = document.getElementById('dropdown-list-donor');
                const search = document.getElementById('editDonorSearchkey');
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', editDonorSearchListener)

                editLoadSearchOptionsForDonor(editDonorResponse.data)

                // const dataContainer = document.getElementById('table-rows')

                // dataContainer.innerHTML = response.html;
                // resizeWindow();

                // dataContainer.classList.remove('fade-in'); // Remove the class to reset animation
                // void dataContainer.offsetWidth; // Trigger reflow
                // dataContainer.classList.add('fade-in'); // Apply fade-in animation
                // document.getElementById('table-pagi').innerHTML = response.pagination;

                // if (page === 1) {
                //     document.getElementById('count').textContent = "From " + response.total + " donations";
                //     DisplayNumber(response.total_received, 'total')
                //     DisplayNumber(response.total_sent, 'spent')
                //     DisplayNumber(response.current_bal, 'current')
                // }
            }
        };

        xhr.send();
    }

    function editDonorSearchListener(event) {

        const key = event.target.value;
        if (key == '') {
            editLoadSearchOptionsForDonor(editDonorResponse.data)
        } else {
            let copyData = editDonorResponse.data.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
            editLoadSearchOptionsForDonor(copyData)


        }
    }

    function editLoadSearchOptionsForDonor(data) {


        const listContainer = document.getElementById('edit-dropdown-list-donor');
        listContainer.innerHTML = ""

        data.forEach(element => {
            // console.log(element);
            const option = document.createElement('div')
            const hr = document.createElement('hr')
            hr.setAttribute('class', 'line')

            option.setAttribute('class', 'dropdown-option');
            option.setAttribute('value', element.ID);
            option.textContent = element.firstname + " " + element.lastname;

            listContainer.appendChild(option);
            listContainer.appendChild(hr)


        });

        listContainer.addEventListener('click', editSelectDonors)

    }

    function editSelectDonors(event) {

        const selectDonor = document.getElementById('edit-donor');
        const selectDonorValue = document.getElementById('edit-donor-value');

        if (event.target.classList.contains('dropdown-option')) {
            selectDonor.setAttribute('value', event.target.textContent)
            selectDonorValue.setAttribute('value', event.target.getAttribute('value'))

            editOpenSelect('edit-dropdown-container-donor', false);
            validateEditForm();

            // console.log(event.target.getAttribute('value'), event.target.textContent);
        }
    }

    function editLoadProjBene(ID) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetProjectAndBeneficents.php', true);
        // document.getElementById('loading-spinner').style.display = 'block';
        // const onload = document.getElementById('onrowload');
        // onload.classList.add('onrowload');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // document.getElementById('loading-spinner').style.display = 'none';
                // // document.getElementById('onrowload').style.display = 'none';
                // onload.classList.remove('onrowload');
                var result = JSON.parse(xhr.responseText);
                // console.log(result);
                editProject = result.data1;
                editBeneficent = result.data;

                // const listContainer = document.getElementById('dropdown-list-donor');
                const search = document.getElementById('editProjectSearchkey');
                const search1 = document.getElementById('editBeneficentSearchkey')
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', editProjectSearchListener)
                search1.addEventListener('input', editBeneSearchListener)

                getSingleSentDonation(ID);

                editLoadSearchOptionsForProject(editProject)

            }
        };

        xhr.send();
    }

    function editProjectSearchListener(event) {
        const key = event.target.value;
        if (key == '') {
            editLoadSearchOptionsForProject(editProject)
        } else {
            let copyData = editProject.filter((ele) =>
                (ele.name).toUpperCase().includes(key.toUpperCase()));
            editLoadSearchOptionsForProject(copyData)


        }
    }

    function editLoadSearchOptionsForProject(data) {

        const listContainer = document.getElementById('edit-dropdown-list-project');
        listContainer.innerHTML = ""

        // console.log(data);


        data.forEach(element => {
            // console.log(element);
            const option = document.createElement('div')
            const hr = document.createElement('hr')
            hr.setAttribute('class', 'line')

            option.setAttribute('class', 'dropdown-option');
            option.setAttribute('value', element.ID);
            option.textContent = element.name;

            listContainer.appendChild(option);
            listContainer.appendChild(hr)


        });

        listContainer.addEventListener('click', editSelectProjects)
    }

    function editSelectProjects(event) {

        const selectDonor = document.getElementById('edit-project');
        const selectDonorValue = document.getElementById('edit-project-value');

        if (event.target.classList.contains('dropdown-option')) {

            const value = event.target.getAttribute('value');
            const textContent = event.target.textContent
            selectDonor.setAttribute('value', textContent)
            selectDonorValue.setAttribute('value', value)

            editOpenSelect('edit-dropdown-container-project', false);
          
            editShowBeneficents(value);

        }

    }

    function editShowBeneficents(value) {
        const beneCont = document.getElementById('edit-beneficent-cont');
        beneCont.style.display = 'flex';

        document.getElementById('edit-beneficent').removeAttribute('value');
        document.getElementById('edit-beneficent-value').removeAttribute('value');
        validateEditForm();

        editSelectedBene = editBeneficent.filter((el) => {
            // console.log(el, value);
            
            return el.project_id === value
        })

        // console.log(selectedBene);
        

        editLoadSearchOptionsForBene(editSelectedBene);

    }

    function currentBeneficents(value) {
        const beneCont = document.getElementById('edit-beneficent-cont');
        beneCont.style.display = 'flex';

        // document.getElementById('edit-beneficent').removeAttribute('value');
        // document.getElementById('edit-beneficent-value').removeAttribute('value');
        validateEditForm();

        editSelectedBene = editBeneficent.filter((el) => {
            // console.log(el, value);
            
            return el.project_id === value
        })

        // console.log(selectedBene);
        

        editLoadSearchOptionsForBene(editSelectedBene);

    }

    function editBeneSearchListener(event) {
        const key = event.target.value;
        if (key == '') {
            editLoadSearchOptionsForBene(editSelectedBene)
        } else {
            let copyData = editSelectedBene.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
            editLoadSearchOptionsForBene(copyData)


        }
    }

    function editLoadSearchOptionsForBene(benes) {
        const listContainer = document.getElementById('edit-dropdown-list-beneficent');
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

        listContainer.addEventListener('click', editSelectBeneficents)
    }

    function editSelectBeneficents(event) {
        const selectDonor = document.getElementById('edit-beneficent');
        const selectDonorValue = document.getElementById('edit-beneficent-value');

        if (event.target.classList.contains('dropdown-option')) {

            const value = event.target.getAttribute('value');
            const textContent = event.target.textContent
            selectDonor.setAttribute('value', textContent)
            selectDonorValue.setAttribute('value', value)

            validateEditForm();
            editOpenSelect('edit-dropdown-container-beneficent', false);

        }

    }

    function validateEditForm(){
        const donor = document.getElementById('edit-donor-value').value.length > 0;
        const date = document.getElementById('edit-date').value.length > 0;
        const project = document.getElementById('edit-project-value').value.length > 0;
        const beneficent = document.getElementById('edit-beneficent-value').value.length > 0;
        const amount = document.getElementById('edit-amount').value.length > 0;
        const purpose = document.getElementById('edit-purpose').value.length > 0;
        const button = document.getElementById('edit-submit');

        if(donor && date && project && beneficent && amount && purpose){
            button.disabled = false;
        } else {
            button.disabled = true;
        }
    }

    function submitEditForm() {
        let button = document.getElementById('edit-submit');
        let button2 = document.getElementById('edit-submiting');
        button.style.display = 'none';
        button2.style.display = 'block';
        return true;
    }
</script>