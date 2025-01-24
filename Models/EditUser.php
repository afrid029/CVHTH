<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/AddUser.css">

</head>



<body>
    <div class="modal-overlay" id="editModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <!-- <div onclick="handleAdd(false)" class='close'>Close</div> -->
            <div class="banner edit-banner">
                Edit User
                <div onclick="closeEdit()" class='close'>Close</div>
            </div>

            <form action="#" method="post" oninput="validateEditForm()" onsubmit="return submitEditForm()">
                <div class="div edit-div"> </div>
                <div class="Form edit-Form">
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

                    <!-- Email -->
                    <div class="FormRow">
                        <input type="email" id="edit-email" name="email" placeholder="Email" required>
                        <small class="small">Email is required</small>
                    </div>

                    <!-- Role -->
                    <div class="FormRow">

                        <select name="role" id="edit-role" required>
                            <option selected hidden value="none">Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="donor">Donor</option>
                            <option value="project manager">Project Manager</option>
                        </select>

                        <small class="small">Role is required</small>
                    </div>

                    <!-- Contact No -->
                    <div class="FormRow">

                        <input type="text" id="edit-contact" name="contact" placeholder="Contact Number" required>

                        <small class="small">Contact Number is required</small>
                    </div>

                    <!-- DOB of Donor -->
                    <div class="FormRow">
                        <div style="display: none;" id="edit-dob-cont">
                        <small style="color: gray; display: flex; width: 100%; font-size: 12px; margin-bottom: 5px; font-family: ubuntu, serif">Date of Birth</small>
                            <input type="date" id="edit-dob" name="dob" placeholder="Date of Birth">
                            <small style="color: green; text-shadow: 0 0 5px green; display: flex; width: 100%" class="small">Optional</small>
                        </div>

                    </div>

                    <!-- Project Selection of PM -->
                    <div style="display: none;" id="edit-project-cont" class="FormRow">
                        <input type="text" name="project" id="edit-project-value" hidden>
                        <input style="cursor: pointer;" type="text" id="edit-project" placeholder="Assign Project(s)" onclick="editOpenSelect('edit-dropdown-container-project',true)" readonly>

                        <div class="edit-dropdown-container dropdown-container" id="edit-dropdown-container-project">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 60%" type="text" id="editProjectSearchkey" placeholder="Search Projects">
                                <input onclick="editOpenSelect('edit-dropdown-container-project',false)" class="search-mobile" style="background-color:rgba(240, 180, 180, 0.79); width: 10%; text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">
                                <input onclick="editClearSelection('edit-project-value','edit-project')" class="search-mobile" style="background-color:rgba(182, 240, 180, 0.79); width: 10%; text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                            </div>
                            <div class="dropdown-list" id="edit-dropdown-list-project">
                                <!-- <div class="dropdown-option" value="1">Hi</div>
                                <div class="dropdown-option" value="2">Hello</div>
                                <div class="dropdown-option" value="3">There</div>
                                <div class="dropdown-option" value="4">It is</div> -->
                            </div>

                        </div>

                        <small class="small green">Optional. You can assign projects later.</small>
                    </div>

                    <!-- Donor selection for PM -->
                    <div style="display: none;" id="edit-donor-cont" class="FormRow">
                        <input type="text" name="donor" id="edit-donor-value" hidden >
                        <input style="cursor: pointer;" type="text" id="edit-donor" placeholder="Assign donors" onclick="editOpenSelect('edit-dropdown-container-donor',true)" readonly>

                        <div class="edit-dropdown-container dropdown-container" id="edit-dropdown-container-donor">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 60%" type="text" id="editDonorSearchkey" placeholder="Search Donors">
                                <input onclick="editOpenSelect('edit-dropdown-container-donor',false)" class="search-mobile" style="background-color:rgba(240, 180, 180, 0.79); width: 10%; text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">
                                <input onclick="editClearSelection('edit-donor-value','edit-donor')" class="search-mobile" style="background-color:rgba(182, 240, 180, 0.79); width: 10%; text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                            </div>
                            <div class="dropdown-list" id="edit-dropdown-list-donor">

                            </div>

                        </div>

                        <small class="small green">Optional. You can assign donors later.</small>
                    </div>

                    <div style="margin-bottom:10px" class="button">
                        <button 
                            type="button"
                            style="background-color: green"
                            onclick="test()"
                            name="submit"
                            id="reset-password"
                            class="submit"> Reset Password
                        </button>
                    </div>

                    <div  class="button">
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


const editToday = new Date();
    const editLocalDate = editToday.toLocaleDateString('en-CA');
    // Set the max attribute to today's date
    document.getElementById('edit-dob').setAttribute('max', editLocalDate);

    let editProjectResponse;
    let editDonorResponse;

    function getSingleUser(ID) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetSingleData.php?ID='+ID+'&type=' + encodeURIComponent('user'), true);
        // document.getElementById('loading-spinner').style.display = 'block';
        // const onload = document.getElementById('onrowload');
        // onload.classList.add('onrowload');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // document.getElementById('loading-spinner').style.display = 'none';
                // // document.getElementById('onrowload').style.display = 'none';
                // onload.classList.remove('onrowload');
                const {data} = JSON.parse(xhr.responseText);
                const {projects} = JSON.parse(xhr.responseText);
                const {donors} = JSON.parse(xhr.responseText);
                console.log(projects);

                document.getElementById('edit-fname').value = data.firstname;
                document.getElementById('edit-lname').value = data.lastname;
                document.getElementById('edit-email').value = data.email;
                document.getElementById('edit-role').value = data.role;
                document.getElementById('edit-contact').value = data.contactno;
                document.getElementById('edit-dob').value = data.dob;
                document.getElementById('projectSearchkey').value = '';
                document.getElementById('donorSearchkey').value = '';

                if(donors.ID){
                    document.getElementById('edit-donor').setAttribute('value',donors.name );
                    document.getElementById('edit-donor-value').setAttribute('value', donors.ID);
                }else {
                    document.getElementById('edit-donor').removeAttribute('value' );
                    document.getElementById('edit-donor-value').removeAttribute('value');
                }
               

                if(projects.ID){
                    document.getElementById('edit-project').setAttribute('value', projects.name);
                    document.getElementById('edit-project-value').setAttribute('value', projects.ID);
                }else {
                    document.getElementById('edit-project').removeAttribute('value' );
                    document.getElementById('edit-project-value').removeAttribute('value');
                }
                

                validateEditForm();




                // const listContainer = document.getElementById('edit-dropdown-list');
                // const search = document.getElementById('editSearchkey');
                // // search.setAttribute('onclick',`searchOption(${response.data})`)

                // search.addEventListener('input', editDonorSearchListener)

                // loadSearchOptions(editDonorResponse.data)

            }
        };

        xhr.send();
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

                // const listContainer = document.getElementById('dropdown-list-project');
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
        // console.log('donor listenmer');

        // const search = document.getElementById('donorSearchkey');
        const key = event.target.value;
        if (key == '') {
            editLoadSearchOptionsForDonor(editDonorResponse.data)
        } else {
            let copyData = editDonorResponse.data.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
            editLoadSearchOptionsForDonor(copyData)


        }
    }

    // window.onload = function() {
    //     loadDonors();
    // }

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

            // console.log('project ', content);



            // openSelect(false); 

            // console.log(event.target.getAttribute('value'), event.target.textContent);
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

        // const selctOption = document.querySelector('.dropdown-option');
        // const selectProject = document.getElementById('select-donor');
        // const selectProjectValue = document.getElementById('select-donor-value');

        listContainer.addEventListener('click', editSelectDonors)

    }

    function editSelectDonors(event) {

        const selectProject = document.getElementById('edit-donor');
        const selectProjectValue = document.getElementById('edit-donor-value');
        if (event.target.classList.contains('dropdown-option')) {

            let available = false;

            let content = selectProject.getAttribute("value");
            let value = selectProjectValue.getAttribute("value");

            console.log(value);
            

            if (value) {
                available = value.split(", ").includes(event.target.getAttribute('value'));
            }

            if (!available) {
                content = content ? content + ", " + event.target.textContent : event.target.textContent;
                selectProject.setAttribute('value', content);


                value = value ? value + ", " + event.target.getAttribute('value') : event.target.getAttribute('value');
                selectProjectValue.setAttribute('value', value)
            }

            // openSelect(false); 

            // console.log(event.target.getAttribute('value'), event.target.textContent);
        }
    }

    function editClearSelection(ID1, ID2){
        document.getElementById(ID1).removeAttribute('value');
        document.getElementById(ID2).removeAttribute('value');
    }



    function validateEditForm() {
        const firstname = document.getElementById('edit-fname').value;
        const lastname = document.getElementById('edit-lname').value;
        const email = document.getElementById('edit-email').value;
        const role = document.getElementById('edit-role').value;
        const contact = document.getElementById('edit-contact').value;
        const dob = document.getElementById('edit-dob-cont');
        const projectContainer = document.getElementById('edit-project-cont');
        const donorContainer = document.getElementById('edit-donor-cont');
        const button = document.getElementById('edit-submit');

        let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        if (role === 'donor') {
            dob.style.display = 'block';
        } else {
            dob.style.display = 'none';
        }

        if(role == 'project manager') {
            projectContainer.style.display = 'flex';
            donorContainer.style.display = 'flex';
        }else {
            projectContainer.style.display = 'none';
            donorContainer.style.display = 'none';

        }



        // console.log(role);

        if (emailPattern.test(email) && firstname.length > 0 && lastname.length > 0 && role !== 'none' && contact.length > 0) {
            button.disabled = false;
        } else {
            button.disabled = true;
        }



        // console.log(donor.value , date.value , amount.value.length);



        // if (donor.value && date.value && amount.value.length > 0) {
        //     // console.log('true');

        //     button.disabled = false;
        // } else {
        //     button.disabled = true;
        //     // console.log('false');

        // }
        // console.log(email);

        // let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        // if (!emailPattern.test(email)) {
        //     event.target.style.border = '1px solid red';
        // } else {
        //     event.target.style.border = '1px solid green';
        // }
    }

    function submitEditForm() {
        let button = document.getElementById('edit-submit');
        let button2 = document.getElementById('edit-submiting');
        document.getElementById('reset-password').disabled = true
        button.style.display = 'none';
        button2.style.display = 'block';
        return true;
    }
</script>