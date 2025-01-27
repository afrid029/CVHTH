<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/AddBeneficent.css">

    </script>
</head>



<body>
    <div
        class="modal-overlay" id="editModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <!-- <div onclick="handleAdd(false)" class='close'>Close</div> -->
            <div class="banner edit-banner">
                Edit Beneficiary
                <div onclick="closeEdit()" class='close'>Close</div>
            </div>

            <form action="/add-beneficiary" method="post" oninput="validateEditForm()" onsubmit="return submitEditForm()" enctype="multipart/form-data">
                <div class="div edit-div"> </div>
                <div class="Form edit-Form">

                
                <!-- ID -->
                <input name = "ID" id="edit-id" type="text" hidden/>

                    <!-- First Name -->
                    <div class="FormRow">
                        <input type="text" id="edit-fname" name="fname" placeholder="First Name" required>
                        <small class="small">First name is required</small>
                    </div>

                    <!-- Last Name -->
                    <div class="FormRow">
                        <input type="text" id="edit-lname" name="lname" placeholder="Last Name" required>
                        <small class="small">Last name is required</small>
                    </div>

                    <!-- NIC -->
                    <div class="FormRow">
                        <input type="text" id="edit-nic" name="nic" placeholder="NIC" required>
                        <small class="small">NIC is required</small>
                    </div>

                    <!-- Gender -->
                    <div class="FormRow">

                        <select name="gender" id="edit-gender" required>
                            <option value="none" selected hidden>Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>

                        <small class="small">Gender is required</small>
                    </div>

                    <!-- DOB -->
                    <div class="FormRow">
                        <small style="color: gray; display: flex; width: 100%; font-size: 12px; margin-bottom: 5px; font-family: Lato, serif">Date of Birth</small>
                        <input type="date" id="edit-date" name="date" required>
                        <small class="small">DOB is required</small>
                    </div>

                    <!-- Dependents -->
                    <div class="FormRow">
                        <input type="text" name="dependant" id="edit-dependant-value" hidden>
                        <input style="cursor: pointer;" type="text" id="edit-dependant" placeholder="Dependant(s)" onclick="editOpenSelect('edit-dropdown-container-dependant',true)" readonly>

                        <div class="dropdown-container edit-dropdown-container" id="edit-dropdown-container-dependant">
                            <div class="dep-cont">
                                <input class="dependant" type="text" name='dname' id='edit-dname' placeholder="Dependant Name">
                                <input class="dependant" type="text" name='relation' id='edit-relation' placeholder="Relation">
                                <input onclick="editAddDependant()" class="dep-btn" style="background-color:rgba(182, 240, 180, 0.79); text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Add">
                                <input onclick="editClearSelection('edit-dependant-value','edit-dependant')" class="dep-btn" style="background-color:rgba(240, 239, 180, 0.79); text-align: center; color:rgb(66, 65, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                                <input onclick="editOpenSelect('edit-dropdown-container-dependant',false)" class="dep-btn" style="background-color:rgba(240, 180, 180, 0.79); text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">

                                
                            </div>


                        </div>

                        <small class="small green">Dependants. Optional</small>
                    </div>

                    <!-- Projects -->

                    <div class="FormRow">
                        <input type="text" name="project" id="edit-project-value" hidden>
                        <input style="cursor: pointer;" type="text" id="edit-project" placeholder="Assign Project(s)" onclick="editOpenSelect('edit-dropdown-container-project',true)" readonly>

                        <div class="dropdown-container edit-dropdown-container" id="edit-dropdown-container-project">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 60%" type="text" id="editProjectSearchkey" placeholder="Search Projects">
                                <input onclick="editOpenSelect('edit-dropdown-container-project',false)" class="search-mobile" style="background-color:rgba(240, 180, 180, 0.79); width: 10%; text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">
                                <input onclick="editClearSelection('edit-project-value','edit-project')" class="search-mobile" style="background-color:rgba(182, 240, 180, 0.79); width: 10%; text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                            </div>
                            <div class="dropdown-list" id="edit-dropdown-list-project">

                            </div>

                        </div>

                        <small class="small green">Optional. You can assign projects later.</small>
                    </div>

                    <!-- Address -->
                    <div class="FormRow">
                        <input type="text" id="edit-address" name="address" placeholder="Address" required>
                        <small class="small">Address is required</small>
                    </div>

                    <!-- GS Division -->
                    <div class="FormRow">
                        <input type="text" id="edit-gs" name="gs" placeholder="GS Division" required>
                        <small class="small">GS division is required</small>
                    </div>

                    <!-- Grade -->
                    <div class="FormRow">
                        <input type="text" id="edit-grade" name="grade" placeholder="Education Qualification">
                        <small class="small green">Optional</small>
                    </div>

                    <!-- School -->
                    <div class="FormRow">
                        <input type="text" id="edit-school" name="school" placeholder="School">
                        <small class="small green">Optional</small>
                    </div>


                    <!-- Images -->
                    <!-- <div class="FormRow">
                    <small style="color: gray; display: flex; width: 100%; font-size: 12px; margin-bottom: 5px; font-family: Lato, serif">Attach Document(s)</small>
                        <input type="file" accept="image/jpeg, image/png, image/gif, image/jpg" id="edit-image" name="image" placeholder="Upload Images" required multiple>
                        <small class="small">Documents required</small>
                        <div id="edit-preview-container" style="display: flex;gap: 5px; flex-wrap:wrap; margin-top: 10px;"></div>
                    </div> -->

                    
<!-- 

                    <script>
                       

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
    let editProjectResponse;

    function getSingleBeneficent(ID) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetSingleData.php?ID='+ID+'&type=' + encodeURIComponent('beneficent'), true);
        // document.getElementById('loading-spinner').style.display = 'block';
        // const onload = document.getElementById('onrowload');
        // onload.classList.add('onrowload');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // document.getElementById('loading-spinner').style.display = 'none';
                // // document.getElementById('onrowload').style.display = 'none';
                // onload.classList.remove('onrowload');
                const {data} = JSON.parse(xhr.responseText);
              


                document.getElementById('edit-id').value = data.ID;  
                document.getElementById("edit-fname").value = data.firstName;
                document.getElementById("edit-lname").value = data.lastName;
                document.getElementById("edit-nic").value = data.NIC;
                document.getElementById("edit-gender").value = data.sex;
                document.getElementById("edit-date").value = data.dob;
                document.getElementById("edit-address").value = data.address;
                document.getElementById("edit-gs").value = data.gsDivision;
                document.getElementById("edit-school").value = data.school;
                document.getElementById("edit-grade").value = data.grade;
                

                if(data.prid){
                    document.getElementById("edit-project-value").setAttribute('value',data.prid);
                    document.getElementById("edit-project").setAttribute('value',data.prname);
                }else {
                    document.getElementById("edit-project-value").removeAttribute('value');
                    document.getElementById("edit-project").removeAttribute('value');
                }

                if(data.depname){
                    document.getElementById("edit-dependant-value").setAttribute('value',data.depname);
                    document.getElementById("edit-dependant").setAttribute('value',data.depnamedisplay);
                }else {
                    document.getElementById("edit-dependant-value").removeAttribute('value');
                    document.getElementById("edit-dependant").removeAttribute('value');
                }

                
                


                // if(data.prid){
                //     document.getElementById('edit-manager-value').setAttribute('value', data.prid);
                //     const adArray = data.prid.split(', ');
                //     console.log(adArray);
                    
                //     let mgrs;
                //     adArray.forEach((element) => {

                //         const mgr = editManagerResponse.data.filter((el) => 
                //              el.ID === element
                //         )

                //         // console.log(mgr.firstname + ' ' + mgr.lastname);
                        

                //         if(mgr){
                //             mgrs = mgrs ? mgrs + ', ' + mgr[0].firstname + ' ' + mgr[0].lastname : mgr[0].firstname + ' ' + mgr[0].lastname
                //         }
                //     })

                //     document.getElementById('edit-manager').setAttribute('value', mgrs);
                   
                    
                    
                // }else {
                //     document.getElementById('edit-manager-value').removeAttribute('value');
                //     document.getElementById('edit-manager').removeAttribute('value');
                // }

                // if(data.benid){

                //     document.getElementById('edit-beneficent-value').setAttribute('value', data.benid);
                //     const adArray = data.benid.split(', ');
                //     // console.log(adArray);
                    
                //     let benes;
                //     adArray.forEach((element) => {

                //         const bene = editBeneficentResponse.data.filter((el) => 
                //              el.ID === element
                //         )

                //         // console.log(mgr.firstname + ' ' + mgr.lastname);
                        

                //         if(bene){
                //             benes = benes ? benes + ', ' + bene[0].firstname + ' ' + bene[0].lastname : bene[0].firstname + ' ' + bene[0].lastname
                //         }
                //     })

                //     document.getElementById('edit-beneficent').setAttribute('value', benes);

                // }else {
                //     document.getElementById('edit-beneficent-value').removeAttribute('value');
                //     document.getElementById('edit-beneficent').removeAttribute('value');
                // }


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

    function editClearSelection(ID1, ID2) {
        document.getElementById(ID1).removeAttribute('value');
        document.getElementById(ID2).removeAttribute('value');
    }

    function editAddDependant() {



        const rel = document.getElementById('edit-relation');
        const dep = document.getElementById('edit-dname');
        const selectDep = document.getElementById('edit-dependant');
        const selectDepVal = document.getElementById('edit-dependant-value');

        // console.log(rel.value);

        if (rel.value.length > 0 && dep.value.length > 0) {
            const displayValue = selectDepVal.value ? selectDep.value + ", " + dep.value + " (" + rel.value + ")" : dep.value + " (" + rel.value + ")";
            const sendValue = selectDepVal.value ? selectDepVal.value + ", " + dep.value + "-" + rel.value : dep.value + "-" + rel.value;

            selectDep.setAttribute('value', displayValue);
            selectDepVal.setAttribute('value', sendValue);

            rel.value = '';
            dep.value = '';
        }


    }

    function editLoadProjects() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetProjectsOnly.php', true);
        // document.getElementById('loading-spinner').style.display = 'block';
        // const onload = document.getElementById('onrowload');
        // onload.classList.add('onrowload');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // document.getElementById('loading-spinner').style.display = 'none';
                // // document.getElementById('onrowload').style.display = 'none';
                // onload.classList.remove('onrowload');
                editProjectResponse = JSON.parse(xhr.responseText);
                // console.log(response.data);

                // const listContainer = document.getElementById('dropdown-list-project');
                const search = document.getElementById('editProjectSearchkey');
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', editProjectSearchListener)

                editLoadSearchOptionsForProject(editProjectResponse.data)

               
            }
        };

        xhr.send();
    }

    function editProjectSearchListener(event) {
        // const search = document.getElementById('projectSearchkey');
        const key = event.target.value;
        if (key == '') {
            editLoadSearchOptionsForProject(editProjectResponse.data)
        } else {
            let copyData = editProjectResponse.data.filter((ele) =>
                ele.name.toUpperCase().includes(key.toUpperCase()));
                editLoadSearchOptionsForProject(copyData)


        }
    }

    function editLoadSearchOptionsForProject(data) {


        const listContainer = document.getElementById('edit-dropdown-list-project');
        listContainer.innerHTML = ""

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

        // const selctOption = document.querySelector('.dropdown-option');
        // const selectProject = document.getElementById('select-project');
        // const selectProjectValue = document.getElementById('select-project-value');

        listContainer.addEventListener('click', editSelectProjects)

    }

    function editSelectProjects(event) {

        // console.log(event);

        const selectProject = document.getElementById('edit-project');
        const selectProjectValue = document.getElementById('edit-project-value');
        if (event.target.classList.contains('dropdown-option')) {
            let available = false;
            let value = selectProjectValue.getAttribute('value');
            let content = selectProject.getAttribute('value');
            // console.log(value);


            if (value) {
                // console.log(value.split(", ").includes(event.target.getAttribute('value')));

                available = value.split(", ").includes(event.target.getAttribute('value'));
            }

            if (!available) {

                content = content ? content + ", " + event.target.textContent : event.target.textContent;
                selectProject.setAttribute('value', content);

                // console.log('project Value ', value);
                value = value ? value + ", " + event.target.getAttribute('value') : event.target.getAttribute('value');
                selectProjectValue.setAttribute('value', value)

            }

        }
    }

    function validateEditForm() {
        const fname = document.getElementById('edit-fname').value.length > 0;
        const lname = document.getElementById('edit-lname').value.length > 0;
        const nic = document.getElementById('edit-nic').value.length > 0;
        const gender = document.getElementById('edit-gender').value !== 'none';
        const date = document.getElementById('edit-date').value.length > 0;
        const address = document.getElementById('edit-address').value.length > 0;
        const gs = document.getElementById('edit-gs').value.length > 0;
        let button = document.getElementById('edit-submit');

        // console.log(selectedImage);


        if (fname && lname && nic && gender && date && address && gs) {
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