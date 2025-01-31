<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/AddProject.css">

    </script>
</head>



<body>
    <div
        class="modal-overlay" id="editModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <!-- <div onclick="handleAdd(false)" class='close'>Close</div> -->
            <div class="banner edit-banner">
                Edit Project
                <div onclick="closeEdit()" class='close'>Close</div>
            </div>

            <form action="/add-project" method="post" oninput="validateEditForm()" onsubmit="return submitEditForm()">
                <div class="div edit-div"> </div>
                <div class="Form edit-Form">

                <!-- ID -->
                <input name = "ID" id="edit-id" type="text" hidden/>

                    <!-- Project Name -->
                    <div class="FormRow">
                        <input type="text" id="edit-pname" name="name" placeholder="Project Name" required>
                        <small class="small">Project name is required</small>
                    </div>

                    <!-- Project Description -->
                    <div class="FormRow">

                        <textarea
                            name="description"
                            placeholder="Description of the project"
                            id="edit-description"
                            maxlength="250"
                            required></textarea>

                        <small class="small">Description is required</small>
                    </div>

                    <!-- Select Managers -->

                    <div class="FormRow">
                        <input type="text" name="manager" id="edit-manager-value" hidden>
                        <input style="cursor: pointer;" type="text" id="edit-manager" placeholder="Assign project manager(s)" onclick="editOpenSelect('edit-dropdown-container-manager',true)" readonly>

                        <div class="dropdown-container edit-dropdown-container" id="edit-dropdown-container-manager">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 60%" type="text" id="editManagerSearchkey" placeholder="Search project manager">
                                <input onclick="editOpenSelect('edit-dropdown-container-manager',false)" class="search-mobile" style="background-color:rgba(240, 180, 180, 0.79); width: 10%; text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">
                                <input onclick="editClearSelection('edit-manager-value','edit-manager')" class="search-mobile" style="background-color:rgba(182, 240, 180, 0.79); width: 10%; text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                            </div>
                            <div class="dropdown-list" id="edit-dropdown-list-manager">

                            </div>

                        </div>

                        <small class="small green">Optional. You can assign project manager later.</small>
                    </div>

                    <!-- Select Beneficents -->
                    <div class="FormRow">
                        <input type="text" name="beneficent" id="edit-beneficent-value" hidden >
                        <input style="cursor: pointer;" type="text" id="edit-beneficent" placeholder="Add Beneficiaries" onclick="editOpenSelect('edit-dropdown-container-beneficent',true)" readonly >

                        <div class="dropdown-container edit-dropdown-container" id="edit-dropdown-container-beneficent">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 60%" type="text" id="editBeneficentSearchkey" placeholder="Search beneficiaries">
                                <input onclick="editOpenSelect('edit-dropdown-container-beneficent',false)" class="search-mobile" style="background-color:rgba(240, 180, 180, 0.79); width: 10%; text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">
                                <input onclick="editClearSelection('edit-beneficent-value','edit-beneficent')" class="search-mobile" style="background-color:rgba(182, 240, 180, 0.79); width: 10%; text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                            </div>
                            <div class="dropdown-list" id="edit-dropdown-list-beneficent">

                            </div>

                        </div>

                        <small class="small green">Optional. You can add beneficiaries later.</small>
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
    let editManagerResponse;
    let editBeneficentResponse;

    function getSingleProject(ID) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetSingleData.php?ID='+ID+'&type=' + encodeURIComponent('project'), true);
        

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                
                const {data} = JSON.parse(xhr.responseText);

                document.getElementById('edit-id').value = data.ID;
                document.getElementById("edit-pname").value = data.name;
                document.getElementById("edit-description").value = data.description;


                if(data.prid){
                    document.getElementById('edit-manager-value').setAttribute('value', data.prid);
                    const adArray = data.prid.split(', ');
                    ////console.log(adArray);
                    
                    let mgrs;
                    adArray.forEach((element) => {

                        const mgr = editManagerResponse.data.filter((el) => 
                             el.ID === element
                        )

                        // ////console.log(mgr.firstname + ' ' + mgr.lastname);
                        

                        if(mgr){
                            mgrs = mgrs ? mgrs + ', ' + mgr[0].firstname + ' ' + mgr[0].lastname : mgr[0].firstname + ' ' + mgr[0].lastname
                        }
                    })

                    document.getElementById('edit-manager').setAttribute('value', mgrs);
                   
                    
                    
                }else {
                    document.getElementById('edit-manager-value').removeAttribute('value');
                    document.getElementById('edit-manager').removeAttribute('value');
                }

                if(data.benid){

                    document.getElementById('edit-beneficent-value').setAttribute('value', data.benid);
                    const adArray = data.benid.split(', ');
                    // ////console.log(adArray);
                    
                    let benes;
                    adArray.forEach((element) => {

                        const bene = editBeneficentResponse.data.filter((el) => 
                             el.ID === element
                        )

                        // ////console.log(mgr.firstname + ' ' + mgr.lastname);
                        

                        if(bene){
                            benes = benes ? benes + ', ' + bene[0].firstname + ' ' + bene[0].lastname : bene[0].firstname + ' ' + bene[0].lastname
                        }
                    })

                    document.getElementById('edit-beneficent').setAttribute('value', benes);

                }else {
                    document.getElementById('edit-beneficent-value').removeAttribute('value');
                    document.getElementById('edit-beneficent').removeAttribute('value');
                }


                validateEditForm();

            }
        };

        xhr.send();
    }

    function editSetTop() {

        const banner = document.querySelector('.edit-banner');
        const form = document.querySelector('.edit-Form');
        const div = document.querySelector('.edit-div');


        const bannerHeight = banner.offsetHeight;
        // ////console.log(bannerHeight);

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

    function editClearSelection(ID1, ID2) {
        document.getElementById(ID1).removeAttribute('value');
        document.getElementById(ID2).removeAttribute('value');
    }



    function editLoadManagers() {

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetAllUsers.php?role=' + encodeURIComponent('project manager'), true);


        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
               
                editManagerResponse = JSON.parse(xhr.responseText);
              
                const search = document.getElementById('editManagerSearchkey');

                search.addEventListener('input', editManagerSearchListener)

                editLoadSearchOptionsForManager(editManagerResponse.data)

            }
        };

        xhr.send();
    }

    function editManagerSearchListener(event) {

        const key = event.target.value;
        if (key == '') {
            editLoadSearchOptionsForManager(editManagerResponse.data)
        } else {
            let copyData = editManagerResponse.data.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
                editLoadSearchOptionsForManager(copyData);
        }

    }

    function editLoadSearchOptionsForManager(data) {

        const listContainer = document.getElementById('edit-dropdown-list-manager');
        listContainer.innerHTML = ""

        data.forEach(element => {

            const option = document.createElement('div')
            const hr = document.createElement('hr')
            hr.setAttribute('class', 'line')

            option.setAttribute('class', 'dropdown-option');
            option.setAttribute('value', element.ID);
            option.textContent = element.firstname + " " + element.lastname;

            // ////console.log(option);

            listContainer.appendChild(option);
            listContainer.appendChild(hr)


        });



        listContainer.addEventListener('click', editSelectManagers)
    }

    function editSelectManagers(event) {

        const selectManager = document.getElementById('edit-manager');
        const selectManagerValue = document.getElementById('edit-manager-value');
        if (event.target.classList.contains('dropdown-option')) {
            let available = false;
            let value = selectManagerValue.getAttribute("value");
            let content = selectManager.getAttribute("value");

            if (value) {
                // ////console.log(value.split(", ").includes(event.target.getAttribute('value')));

                available = value.split(", ").includes(event.target.getAttribute('value'));
            }

            if (!available) {

                content = content ? content + ", " + event.target.textContent : event.target.textContent;
                selectManager.setAttribute('value', content);

                // ////console.log('project Value ', value);
                value = value ? value + ", " + event.target.getAttribute('value') : event.target.getAttribute('value');
                selectManagerValue.setAttribute('value', value)

            }

        }
    }


    function editLoadBeneficents(ID) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetBeneficersOnly.php', true);
        

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                
                editBeneficentResponse = JSON.parse(xhr.responseText);
                
                const search = document.getElementById('editBeneficentSearchkey');
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', editBeneficentSearchListener)
                getSingleProject(ID);

                editLoadSearchOptionsForBeneficent(editBeneficentResponse.data)

            }
        };

        xhr.send();
    }

    function editBeneficentSearchListener(event) {

        const key = event.target.value;
        if (key == '') {
            editLoadSearchOptionsForBeneficent(editBeneficentResponse.data)
        } else {
            let copyData = editBeneficentResponse.data.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
                editLoadSearchOptionsForBeneficent(copyData);
        }

    }

    function editLoadSearchOptionsForBeneficent(data) {

        const listContainer = document.getElementById('edit-dropdown-list-beneficent');
        listContainer.innerHTML = ""

        data.forEach(element => {

            const option = document.createElement('div')
            const hr = document.createElement('hr')
            hr.setAttribute('class', 'line')

            option.setAttribute('class', 'dropdown-option');
            option.setAttribute('value', element.ID);
            option.textContent = element.firstname + " " + element.lastname;

            // ////console.log(option);

            listContainer.appendChild(option);
            listContainer.appendChild(hr)


        });

       

        listContainer.addEventListener('click', editSelectBeneficents)
    }

    function editSelectBeneficents(event) {

        const selectBeneficent = document.getElementById('edit-beneficent');
        const selectBeneficentValue = document.getElementById('edit-beneficent-value');
        if (event.target.classList.contains('dropdown-option')) {
            let available = false;
            let value = selectBeneficentValue.getAttribute("value");
            let content = selectBeneficent.getAttribute("value");

            if (value) {
                // ////console.log(value.split(", ").includes(event.target.getAttribute('value')));

                available = value.split(", ").includes(event.target.getAttribute('value'));
            }

            if (!available) {

                content = content ? content + ", " + event.target.textContent : event.target.textContent;
                selectBeneficent.setAttribute('value', content);

                // ////console.log('project Value ', value);
                value = value ? value + ", " + event.target.getAttribute('value') : event.target.getAttribute('value');
                selectBeneficentValue.setAttribute('value', value)

            }

        }
    }

    function validateEditForm() {
        let name = document.getElementById('edit-pname').value.length > 0;
        let des = document.getElementById('edit-description').value.length > 0;
        let button = document.getElementById('edit-submit');

        if(name && des) {
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