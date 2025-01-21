<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/AddUser.css">

    </script>
</head>



<body>
    <div
        class="modal-overlay" id="addModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <!-- <div onclick="handleAdd(false)" class='close'>Close</div> -->
            <div class="banner">
                Create User
                <div onclick="handleAdd(false)" class='close'>Close</div>
            </div>

            <form action="#" method="post" oninput="validateForm()" onsubmit="return submitLoginform()">
                <div class="div"> </div>
                <div class="Form">
                    <div class="FormRow">
                        <input type="text" id="select-fname" name="fname" placeholder="First Name" required>
                        <small class="small">First name is required</small>
                    </div>
                    <div class="FormRow">
                        <input type="text" id="select-lname" name="lname" placeholder="Last Name" required>
                        <small class="small">Last name is required</small>
                    </div>
                    <div class="FormRow">
                        <input type="email" id="select-email" name="email" placeholder="Email" required>
                        <small class="small">Email is required</small>
                    </div>
                    <div class="FormRow">

                        <select name="role" id="select-role" required>
                            <option selected hidden value="none">Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="donor">Donor</option>
                            <option value="project manager">Project Manager</option>
                        </select>

                        <small class="small">Role is required</small>
                    </div>
                    <div class="FormRow">

                        <input type="text" id="select-contact" name="contact" placeholder="Contact Number" required>

                        <small class="small">Contact Number is required</small>
                    </div>

                    <div class="FormRow">
                        <div style="display: none;" id="select-dob-cont">
                        <small style="color: gray; display: flex; width: 100%; font-size: 12px; margin-bottom: 5px; font-family: ubuntu, serif">Date of Birth</small>
                            <input type="date" id="select-dob" name="dob" placeholder="Date of Birth">
                            <small style="color: green; text-shadow: 0 0 5px green; display: flex; width: 100%" class="small">Optional</small>
                        </div>

                    </div>

                    <div style="display: none;" id="select-project-cont" class="FormRow">
                        <input type="text" name="project" id="select-project-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="select-project" placeholder="Assign Project(s)" onclick="openSelect('dropdown-container-project',true)" readonly required>

                        <div class="dropdown-container" id="dropdown-container-project">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 60%" type="text" id="projectSearchkey" placeholder="Search Projects">
                                <input onclick="openSelect('dropdown-container-project',false)" class="search-mobile" style="background-color:rgba(240, 180, 180, 0.79); width: 10%; text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">
                                <input onclick="ClearSelection('select-project-value','select-project')" class="search-mobile" style="background-color:rgba(182, 240, 180, 0.79); width: 10%; text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                            </div>
                            <div class="dropdown-list" id="dropdown-list-project">
                                <!-- <div class="dropdown-option" value="1">Hi</div>
                                <div class="dropdown-option" value="2">Hello</div>
                                <div class="dropdown-option" value="3">There</div>
                                <div class="dropdown-option" value="4">It is</div> -->
                            </div>

                        </div>

                        <small class="small green">Optional. You can assign projects later.</small>
                    </div>

                    <div style="display: none;" id="select-donor-cont" class="FormRow">
                        <input type="text" name="donor" id="select-donor-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="select-donor" placeholder="Assign donors" onclick="openSelect('dropdown-container-donor',true)" readonly required>

                        <div class="dropdown-container" id="dropdown-container-donor">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 60%" type="text" id="donorSearchkey" placeholder="Search Donors">
                                <input onclick="openSelect('dropdown-container-donor',false)" class="search-mobile" style="background-color:rgba(240, 180, 180, 0.79); width: 10%; text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">
                                <input onclick="ClearSelection('select-donor-value','select-donor')" class="search-mobile" style="background-color:rgba(182, 240, 180, 0.79); width: 10%; text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                            </div>
                            <div class="dropdown-list" id="dropdown-list-donor">

                            </div>

                        </div>

                        <small class="small green">Optional. You can assign donors later.</small>
                    </div>

                    <div class="button">
                        <button
                            type="submit"
                            id="submit"
                            name="submit"
                            disabled="true"
                            class="submit"> Add User
                        </button>

                        <button
                            style="display: none;"
                            id="submiting"
                            disabled="true"
                            class="submit"> Adding...
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
    let donorResponse;

    function loadProjects() {
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
                projectResponse = JSON.parse(xhr.responseText);
                // console.log(response.data);

                // const listContainer = document.getElementById('dropdown-list-project');
                const search = document.getElementById('projectSearchkey');
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', projectSearchListener)

                loadSearchOptionsForProject(projectResponse.data)

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

    function loadDonors() {


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
                donorResponse = JSON.parse(xhr.responseText);
                // console.log(response.data);

                // const listContainer = document.getElementById('dropdown-list-project');
                const search = document.getElementById('donorSearchkey');
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', donorSearchListener)

                loadSearchOptionsForDonor(donorResponse.data)

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

    function donorSearchListener(event) {
        // console.log('donor listenmer');

        // const search = document.getElementById('donorSearchkey');
        const key = event.target.value;
        if (key == '') {
            loadSearchOptionsForDonor(donorResponse.data)
        } else {
            let copyData = donorResponse.data.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
            loadSearchOptionsForDonor(copyData)


        }
    }

    // window.onload = function() {
    //     loadDonors();
    // }

    function setTop() {

        const banner = document.querySelector('.banner');
        const form = document.querySelector('.form');
        const div = document.querySelector('.div');


        const bannerHeight = banner.offsetHeight;
        // console.log(bannerHeight);

        form.style.top = `calc(${bannerHeight}px + 10px)`;
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

    function loadSearchOptionsForProject(data) {


        const listContainer = document.getElementById('dropdown-list-project');
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

        listContainer.addEventListener('click', selectProjects)

    }

    function selectProjects(event) {

        // console.log(event);

        const selectProject = document.getElementById('select-project');
        const selectProjectValue = document.getElementById('select-project-value');
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

    function loadSearchOptionsForDonor(data) {


        const listContainer = document.getElementById('dropdown-list-donor');
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

        listContainer.addEventListener('click', selectDonors)

    }

    function selectDonors(event) {

        const selectProject = document.getElementById('select-donor');
        const selectProjectValue = document.getElementById('select-donor-value');
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

    function ClearSelection(ID1, ID2){
        document.getElementById(ID1).removeAttribute('value');
        document.getElementById(ID2).removeAttribute('value');
    }



    function validateForm() {
        const firstname = document.getElementById('select-fname').value;
        const lastname = document.getElementById('select-lname').value;
        const email = document.getElementById('select-email').value;
        const role = document.getElementById('select-role').value;
        const contact = document.getElementById('select-contact').value;
        const dob = document.getElementById('select-dob-cont');
        const projectContainer = document.getElementById('select-project-cont');
        const donorContainer = document.getElementById('select-donor-cont');
        const button = document.getElementById('submit');

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



        // console.log(role.value);

        if (emailPattern.test(email) && firstname.length > 0 && lastname.length > 0 && role.length > 0 && contact.length > 0) {
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

    function submitLoginform() {
        let button = document.getElementById('submit');
        let button2 = document.getElementById('submiting');
        button.style.display = 'none';
        button2.style.display = 'block';
        return true;
    }
</script>