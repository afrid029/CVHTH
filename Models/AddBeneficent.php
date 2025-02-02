<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/AddBeneficent.css">

    </script>
</head>



<body>
    <div
        class="modal-overlay" id="addModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <!-- <div onclick="handleAdd(false)" class='close'>Close</div> -->
            <div class="banner">
                Create Beneficiary
                <div onclick="handleAdd(false)" class='close'>Close</div>
            </div>

            <form id="beneForm"  method="post" oninput="validateForm()"  enctype="multipart/form-data">
                <div class="div"> </div>
                <div class="Form">

                    <!-- First Name -->
                    <div class="FormRow">
                        <input type="text" id="select-fname" name="fname" placeholder="First Name" required>
                        <small class="small">First name is required</small>
                    </div>

                    <!-- Last Name -->
                    <div class="FormRow">
                        <input type="text" id="select-lname" name="lname" placeholder="Last Name" required>
                        <small class="small">Last name is required</small>
                    </div>

                    <!-- NIC -->
                    <div class="FormRow">
                        <input type="text" id="select-nic" name="nic" placeholder="NIC" required>
                        <small class="small">NIC is required</small>
                    </div>

                    <!-- Gender -->
                    <div class="FormRow">

                        <select name="gender" id="select-gender" required>
                            <option value="none" selected hidden>Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>

                        <small class="small">Gender is required</small>
                    </div>

                    <!-- DOB -->
                    <div class="FormRow">
                        <small style="color: gray; display: flex; width: 100%; font-size: 12px; margin-bottom: 5px; font-family: Lato, serif">Date of Birth</small>
                        <input type="date" id="select-date" name="date" required>
                        <small class="small">DOB is required</small>
                    </div>

                    <!-- Dependents -->
                    <div class="FormRow">
                        <input type="text" name="dependant" id="select-dependant-value" hidden>
                        <input style="cursor: pointer;" type="text" id="select-dependant" placeholder="Dependant(s)" onclick="openSelect('dropdown-container-dependant',true)" readonly>

                        <div class="dropdown-container" id="dropdown-container-dependant">
                            <div class="dep-cont">
                                <input class="dependant" type="text" name='dname' id='select-dname' placeholder="Dependant Name">
                                <input class="dependant" type="text" name='relation' id='select-relation' placeholder="Relation">
                                <input onclick="AddDependant()" class="dep-btn" style="background-color:rgba(182, 240, 180, 0.79); text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Add">
                                <input onclick="ClearSelection('select-dependant-value','select-dependant')" class="dep-btn" style="background-color:rgba(240, 239, 180, 0.79); text-align: center; color:rgb(66, 65, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                                <input onclick="openSelect('dropdown-container-dependant',false)" class="dep-btn" style="background-color:rgba(240, 180, 180, 0.79); text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">

                               
                            </div>


                        </div>

                        <small class="small green">Optional</small>
                    </div>

                    <!-- Projects -->

                    <div class="FormRow">
                        <input type="text" name="project" id="select-project-value" hidden>
                        <input style="cursor: pointer;" type="text" id="select-project" placeholder="Assign Project(s)" onclick="openSelect('dropdown-container-project',true)" readonly>

                        <div class="dropdown-container" id="dropdown-container-project">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 60%" type="text" id="projectSearchkey" placeholder="Search Projects">
                                <input onclick="openSelect('dropdown-container-project',false)" class="search-mobile" style="background-color:rgba(240, 180, 180, 0.79); width: 10%; text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">
                                <input onclick="ClearSelection('select-project-value','select-project')" class="search-mobile" style="background-color:rgba(182, 240, 180, 0.79); width: 10%; text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                            </div>
                            <div class="dropdown-list" id="dropdown-list-project">

                            </div>

                        </div>

                        <small class="small green">Optional. You can assign projects later.</small>
                    </div>

                    <!-- Address -->
                    <div class="FormRow">
                        <input type="text" id="select-address" name="address" placeholder="Address" required>
                        <small class="small">Address is required</small>
                    </div>

                    <!-- GS Division -->
                    <div class="FormRow">
                        <input type="text" id="select-gs" name="gs" placeholder="GS Division" required>
                        <small class="small">GS division is required</small>
                    </div>

                    <!-- Grade -->
                    <div class="FormRow">
                        <input type="text" id="select-grade" name="grade" placeholder="Education Qualification">
                        <small class="small green">Optional</small>
                    </div>

                    <!-- School -->
                    <div class="FormRow">
                        <input type="text" id="select-school" name="school" placeholder="School">
                        <small class="small green">Optional</small>
                    </div>


                    <!-- Images -->
                    <div class="FormRow">
                    <small style="color: gray; display: flex; width: 100%; font-size: 12px; margin-bottom: 5px; font-family: Lato, serif">Attach Document(s)</small>
                        <input type="file" accept="image/jpeg, image/png, image/gif, image/jpg" id="select-image" name="image[]" placeholder="Upload Images" multiple  hidden>
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
                            // //console.log(val);
                            const newFiles = Array.from(event.target.files);
                          
                            // const files = event.target.files;
                           

                            if (newFiles.length + allFiles.length > 6) {
                                alert('You can select a maximum of 6 images.');
                                event.target.value = '';
                                validateForm(); // Clear the input (prevents submitting the 7th file)
                                return;
                            }

                            allFiles = [...allFiles, ...newFiles];
                            // console.log(allFiles);
                            
                            // console.log(fileNames);
                            
                            
                            event.target.value = '';
                            displayImages();
                            validateForm();

                            // Loop through the selected files
                            
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
                            class="submit"> Create Beneficiary
                        </button>

                        <button
                            style="display: none;"
                            id="submiting"
                            disabled="true"
                            class="submit"> Creating...
                        </button>
                    </div>

                </div>


            </form>
        </div>



    </div>
</body>

</html>

<script>
    let projectResponse;

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

    function ClearSelection(ID1, ID2) {
        document.getElementById(ID1).removeAttribute('value');
        document.getElementById(ID2).removeAttribute('value');
    }

    function AddDependant() {



        const rel = document.getElementById('select-relation');
        const dep = document.getElementById('select-dname');
        const selectDep = document.getElementById('select-dependant');
        const selectDepVal = document.getElementById('select-dependant-value');

        //console.log(rel.value);

        if (rel.value.length > 0 && dep.value.length > 0) {
            const displayValue = selectDepVal.value ? selectDep.value + ", " + dep.value + " (" + rel.value + ")" : dep.value + " (" + rel.value + ")";
            const sendValue = selectDepVal.value ? selectDepVal.value + ", " + dep.value + "-" + rel.value : dep.value + "-" + rel.value;

            selectDep.setAttribute('value', displayValue);
            selectDepVal.setAttribute('value', sendValue);

            rel.value = '';
            dep.value = '';
        }


    }

    function loadProjects() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetProjectsOnly.php', true);
        

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // document.getElementById('loading-spinner').style.display = 'none';
                // // document.getElementById('onrowload').style.display = 'none';
                // onload.classList.remove('onrowload');
                projectResponse = JSON.parse(xhr.responseText);
                // //console.log(response.data);

                // const listContainer = document.getElementById('dropdown-list-project');
                const search = document.getElementById('projectSearchkey');
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', projectSearchListener)

                loadSearchOptionsForProject(projectResponse.data)

               
            }
        };

        xhr.send();
    }

    function projectSearchListener(event) {
        // const search = document.getElementById('projectSearchkey');
        const key = event.target.value;
        if (key == '') {
            loadSearchOptionsForProject(projectResponse.data)
        } else {
            let copyData = projectResponse.data.filter((ele) =>
                ele.name.toUpperCase().includes(key.toUpperCase()));
            loadSearchOptionsForProject(copyData)


        }
    }

    function loadSearchOptionsForProject(data) {


        const listContainer = document.getElementById('dropdown-list-project');
        listContainer.innerHTML = ""

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

        // //console.log(event);

        const selectProject = document.getElementById('select-project');
        const selectProjectValue = document.getElementById('select-project-value');
        if (event.target.classList.contains('dropdown-option')) {
            let available = false;
            let value = selectProjectValue.getAttribute('value');
            let content = selectProject.getAttribute('value');
            // //console.log(value);


            if (value) {
                // //console.log(value.split(", ").includes(event.target.getAttribute('value')));

                available = value.split(", ").includes(event.target.getAttribute('value'));
            }

            if (!available) {

                content = content ? content + ", " + event.target.textContent : event.target.textContent;
                selectProject.setAttribute('value', content);

                // //console.log('project Value ', value);
                value = value ? value + ", " + event.target.getAttribute('value') : event.target.getAttribute('value');
                selectProjectValue.setAttribute('value', value)

            }

            // //console.log('project ', content);



            // openSelect(false); 

            // //console.log(event.target.getAttribute('value'), event.target.textContent);
        }
    }

    function validateForm() {
        const fname = document.getElementById('select-fname').value.length > 0;
        const lname = document.getElementById('select-lname').value.length > 0;
        const nic = document.getElementById('select-nic').value.length > 0;
        const gender = document.getElementById('select-gender').value !== 'none';
        const date = document.getElementById('select-date').value.length > 0;
        const address = document.getElementById('select-address').value.length > 0;
        const gs = document.getElementById('select-gs').value.length > 0;
        const selectedImage = document.getElementById('select-image').value;
        let button = document.getElementById('submit');

        //console.log(selectedImage);


        if (fname && lname && nic && gender && date && address && gs && allFiles.length > 0) {
            button.disabled = false;
        } else {
            button.disabled = true;
        }


    }


    document.getElementById('beneForm').addEventListener('submit', function(event){
        let button = document.getElementById('submit');
        let button2 = document.getElementById('submiting');
        button.style.display = 'none';
        button2.style.display = 'block';

        event.preventDefault();

        const formData = new FormData;

        allFiles.forEach(file => {
            formData.append('image[]', file);
        });

        const fname = document.getElementById('select-fname').value;
        const lname = document.getElementById('select-lname').value;
        const nic = document.getElementById('select-nic').value;
        const gender = document.getElementById('select-gender').value;
        const date = document.getElementById('select-date').value;
        const  dependant = document.getElementById('select-dependant-value').value;
        const project = document.getElementById('select-project-value').value;
        const address = document.getElementById('select-address').value;
        const gs = document.getElementById('select-gs').value;
        const grade = document.getElementById('select-grade').value;
        const school = document.getElementById('select-school').value;

        formData.append('fname', fname);
        formData.append('lname', lname);
        formData.append('nic', nic);
        formData.append('gender', gender);
        formData.append('date', date);
        formData.append('dependant',dependant);
        formData.append('project',project);
        formData.append('address',address);
        formData.append('gs',gs);
        formData.append('grade',grade);
        formData.append('school',school);
        formData.append('submit', true);

        // console.log(formData)
        

        const xhr = new XMLHttpRequest();
    xhr.open('POST', '/add-beneficiary', true);
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