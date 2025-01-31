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
                Edit Disbursed Donation
                <div onclick="closeEdit()" class='close'>Close</div>
            </div>

            <form action="/add-sentdonation" method="post" oninput="validateEditForm()" onsubmit="return submitEditForm()" enctype="multipart/form-data">
            <!-- <form action="/#" method="post"> -->
                <div class="div edit-div"> </div>
                <div class="Form edit-Form">

                <!-- ID -->
                <input name = "ID" id="edit-id" type="text" hidden/>

                    <!-- Enter Amount -->
                    <div class="FormRow">

                        <input
                            type="number"
                            name="amount"
                            placeholder="Serving Amount (Rs)"
                            oninput="AmountDonar()"
                            min="1"
                            id="edit-amount"
                            required />

                        <small class="small">Amount is required</small>
                    </div>

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
                        <small ID='edit-not-enough' style="display: none; color: #765309" class="small">Donor has not sufficient balance.</small>

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

                    

                    <div class="button">
                        <button
                            type="submit"
                            id="edit-submit"
                            name="edit-submit"
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
   

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
               
                const {data} = JSON.parse(xhr.responseText);
                //console.log(data);

                document.getElementById('edit-id').value = data.ID;
                // document.getElementById("edit-donor-value").setAttribute('value', data.Donor_ID);

                if(data.Donor_ID){
                    document.getElementById("edit-donor-value").setAttribute('value', data.Donor_ID);

                    for(const el of editDonorResponse.data){
                        if(el.ID === data.Donor_ID){
                            document.getElementById("edit-donor").setAttribute('value', el.firstname + " " + el.lastname);
                            break;
                        }
                    }
                }else {
                    document.getElementById("edit-donor-value").removeAttribute('value')
                    document.getElementById("edit-donor").removeAttribute('value')
                }           
                
                if(data.Project_ID){
                    document.getElementById("edit-project-value").setAttribute('value', data.Project_ID);

                    for(const el of editProject) {
                        if(el.ID === data.Project_ID){
                            document.getElementById("edit-project").setAttribute('value', el.name);
                            currentBeneficents(el.ID);
                            break;
                        }
                    }
                }else {
                    document.getElementById("edit-project-value").removeAttribute('value');
                    document.getElementById("edit-project").removeAttribute('value');
                }
              

                if(data.Beneficiant_ID){
                    document.getElementById("edit-beneficent-value").setAttribute('value', data.Beneficiant_ID);

                    for(const el of editBeneficent) {
                        if(el.ID === data.Beneficiant_ID){
                            document.getElementById("edit-beneficent").setAttribute('value',  el.firstname + " " + el.lastname);
                            break;
                        }
                    }
                }else {
                    document.getElementById("edit-beneficent-value").removeAttribute('value');
                    document.getElementById("edit-beneficent").removeAttribute('value');
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
        // //console.log(bannerHeight);

        // form.style.top = `calc(${bannerHeight}px + 10px)`;
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
                
                editDonorResponse = JSON.parse(xhr.responseText);

               
                const search = document.getElementById('editDonorSearchkey');

                search.addEventListener('input', editDonorSearchListener)

                editLoadSearchOptionsForDonor(editDonorResponse.data)

               
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
            // //console.log(element);
            const option = document.createElement('div')
            const hr = document.createElement('hr')
            hr.setAttribute('class', 'line')

            option.setAttribute('class', 'dropdown-option');
            option.setAttribute('value', element.ID);
            option.textContent = element.firstname + " " + element.lastname;

            const small = document.createElement('div');
            small.setAttribute('class','balance')
            small.textContent = 'Balance (Rs) : ' + element.balance;
            option.appendChild(small);


            listContainer.appendChild(option);
            listContainer.appendChild(hr)


        });

        listContainer.addEventListener('click', editSelectDonors)

    }

    function editSelectDonors(event) {

        const selectDonor = document.getElementById('edit-donor');
        const selectDonorValue = document.getElementById('edit-donor-value');

        if (event.target.classList.contains('dropdown-option')) {
            const name = event.target.textContent.split('Balance')
            selectDonor.setAttribute('value', name[0])
            // selectDonor.setAttribute('value', name)
            selectDonorValue.setAttribute('value', event.target.getAttribute('value'))

            editOpenSelect('edit-dropdown-container-donor', false);
            // validateEditForm();
            AmountDonar();

            // //console.log(event.target.getAttribute('value'), event.target.textContent);
        }
    }

    function editLoadProjBene(ID) {
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
                editProject = result.data1;
                editBeneficent = result.data;

                
                const search = document.getElementById('editProjectSearchkey');
                const search1 = document.getElementById('editBeneficentSearchkey')

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
            // //console.log(el, value);
            
            return el.project_id === value
        })

        // //console.log(selectedBene);
        

        editLoadSearchOptionsForBene(editSelectedBene);

    }

    function currentBeneficents(value) {
        const beneCont = document.getElementById('edit-beneficent-cont');
        beneCont.style.display = 'flex';

      
        validateEditForm();

        editSelectedBene = editBeneficent.filter((el) => {
            // //console.log(el, value);
            
            return el.project_id === value
        })

        // //console.log(selectedBene);
        

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

    function AmountDonar(){
        const donor = document.getElementById('edit-donor-value').value;
        const amount = document.getElementById('edit-amount').value;
        if(donor.length > 0 && amount.length > 0){
            const selectedDonor = editDonorResponse.data.filter((ele) =>
            (ele.ID === donor));
            //console.log(selectedDonor);
            
            if(parseInt(selectedDonor[0].balance) < amount){
                
                
                document.getElementById('edit-not-enough').style.display = 'flex';
                document.getElementById('edit-donor-value').removeAttribute('value');
                document.getElementById('edit-donor').removeAttribute('value');
                // validateForm();
                validateEditForm();

            }else {
                document.getElementById('edit-not-enough').style.display = 'none';
                // validateForm();
                validateEditForm();
            }
        }
        
    }
    function validateEditForm(){
        const donor = document.getElementById('edit-donor-value').value;
        const date = document.getElementById('edit-date').value.length > 0;
        const project = document.getElementById('edit-project-value').value.length > 0;
        const beneficent = document.getElementById('edit-beneficent-value').value.length > 0;
        const amount = document.getElementById('edit-amount').value;
        const purpose = document.getElementById('edit-purpose').value.length > 0;
        const button = document.getElementById('edit-submit');



        if(donor.length > 0 && date && project && beneficent && amount.length > 0 && purpose){
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