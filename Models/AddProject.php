<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/AddProject.css">

    </script>
</head>



<body>
    <div
        class="modal-overlay" id="addModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <!-- <div onclick="handleAdd(false)" class='close'>Close</div> -->
            <div class="banner">
                Create Project
                <div onclick="handleAdd(false)" class='close'>Close</div>
            </div>

            <form action="#" method="post" oninput="validateForm()" onsubmit="return submitLoginform()">
                <div class="div"> </div>
                <div class="Form">

                    <!-- Project Name -->
                    <div class="FormRow">
                        <input type="text" id="select-pname" name="name" placeholder="Project Name" required>
                        <small class="small">Project name is required</small>
                    </div>

                    <!-- Project Description -->
                    <div class="FormRow">

                        <textarea
                            name="description"
                            placeholder="Description of the project"
                            id="select-description"
                            maxlength="250"
                            required></textarea>

                        <small class="small">Description is required</small>
                    </div>

                    <!-- Select Managers -->

                    <div class="FormRow">
                        <input type="text" name="manager" id="select-manager-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="select-manager" placeholder="Assign project manager(s)" onclick="openSelect('dropdown-container-manager',true)" readonly required>

                        <div class="dropdown-container" id="dropdown-container-manager">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 60%" type="text" id="managerSearchkey" placeholder="Search project manager">
                                <input onclick="openSelect('dropdown-container-manager',false)" class="search-mobile" style="background-color:rgba(240, 180, 180, 0.79); width: 10%; text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">
                                <input onclick="ClearSelection('select-manager-value','select-manager')" class="search-mobile" style="background-color:rgba(182, 240, 180, 0.79); width: 10%; text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                            </div>
                            <div class="dropdown-list" id="dropdown-list-manager">

                            </div>

                        </div>

                        <small class="small green">Optional. You can assign project manager later.</small>
                    </div>

                    <!-- Select Beneficents -->
                    <div class="FormRow">
                        <input type="text" name="beneficent" id="select-beneficent-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="select-beneficent" placeholder="Add Beneficiaries" onclick="openSelect('dropdown-container-beneficent',true)" readonly required>

                        <div class="dropdown-container" id="dropdown-container-beneficent">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 60%" type="text" id="beneficentSearchkey" placeholder="Search beneficiaries">
                                <input onclick="openSelect('dropdown-container-beneficent',false)" class="search-mobile" style="background-color:rgba(240, 180, 180, 0.79); width: 10%; text-align: center; color:rgba(145, 11, 11, 0.79); font-weight: 700; cursor: pointer" type="text" readonly value="Close">
                                <input onclick="ClearSelection('select-beneficent-value','select-beneficent')" class="search-mobile" style="background-color:rgba(182, 240, 180, 0.79); width: 10%; text-align: center; color:rgb(17, 66, 2); font-weight: 700; cursor: pointer" type="text" readonly value="Clear">
                            </div>
                            <div class="dropdown-list" id="dropdown-list-beneficent">

                            </div>

                        </div>

                        <small class="small green">Optional. You can add beneficiaries later.</small>
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
    let managerResponse;
    let beneficentResponse;

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

    function ClearSelection(ID1, ID2) {
        document.getElementById(ID1).removeAttribute('value');
        document.getElementById(ID2).removeAttribute('value');
    }



    function loadManagers() {

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetAllUsers.php?role=' + encodeURIComponent('project manager'), true);
        // document.getElementById('loading-spinner').style.display = 'block';
        // const onload = document.getElementById('onrowload');
        // onload.classList.add('onrowload');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // document.getElementById('loading-spinner').style.display = 'none';
                // // document.getElementById('onrowload').style.display = 'none';
                // onload.classList.remove('onrowload');
                managerResponse = JSON.parse(xhr.responseText);
                // console.log(response.data);

                // const listContainer = document.getElementById('dropdown-list-manager');
                const search = document.getElementById('managerSearchkey');
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', managerSearchListener)

                loadSearchOptionsForManager(managerResponse.data)

            }
        };

        xhr.send();
    }

    function managerSearchListener(event) {

        const key = event.target.value;
        if (key == '') {
            loadSearchOptionsForManager(managerResponse.data)
        } else {
            let copyData = managerResponse.data.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
            loadSearchOptionsForManager(copyData);
        }

    }

    function loadSearchOptionsForManager(data) {

        const listContainer = document.getElementById('dropdown-list-manager');
        listContainer.innerHTML = ""

        data.forEach(element => {

            const option = document.createElement('div')
            const hr = document.createElement('hr')
            hr.setAttribute('class', 'line')

            option.setAttribute('class', 'dropdown-option');
            option.setAttribute('value', element.ID);
            option.textContent = element.firstname + " " + element.lastname;

            // console.log(option);

            listContainer.appendChild(option);
            listContainer.appendChild(hr)


        });

        // const selctOption = document.querySelector('.dropdown-option');
        // const selectProject = document.getElementById('select-project');
        // const selectProjectValue = document.getElementById('select-project-value');

        listContainer.addEventListener('click', selectManagers)
    }

    function selectManagers(event) {

        const selectManager = document.getElementById('select-manager');
        const selectManagerValue = document.getElementById('select-manager-value');
        if (event.target.classList.contains('dropdown-option')) {
            let available = false;
            let value = selectManagerValue.getAttribute("value");
            let content = selectManager.getAttribute("value");

            if (value) {
                // console.log(value.split(", ").includes(event.target.getAttribute('value')));

                available = value.split(", ").includes(event.target.getAttribute('value'));
            }

            if (!available) {

                content = content ? content + ", " + event.target.textContent : event.target.textContent;
                selectManager.setAttribute('value', content);

                // console.log('project Value ', value);
                value = value ? value + ", " + event.target.getAttribute('value') : event.target.getAttribute('value');
                selectManagerValue.setAttribute('value', value)

            }

        }
    }


    function loadBeneficents() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetNewBeneficent.php', true);
        // document.getElementById('loading-spinner').style.display = 'block';
        // const onload = document.getElementById('onrowload');
        // onload.classList.add('onrowload');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // document.getElementById('loading-spinner').style.display = 'none';
                // // document.getElementById('onrowload').style.display = 'none';
                // onload.classList.remove('onrowload');
                beneficentResponse = JSON.parse(xhr.responseText);
                // console.log(response.data);

                // const listContainer = document.getElementById('dropdown-list-manager');
                const search = document.getElementById('beneficentSearchkey');
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', beneficentSearchListener)

                loadSearchOptionsForBeneficent(beneficentResponse.data)

            }
        };

        xhr.send();
    }

    function beneficentSearchListener(event) {

        const key = event.target.value;
        if (key == '') {
            loadSearchOptionsForBeneficent(beneficentResponse.data)
        } else {
            let copyData = beneficentResponse.data.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
            loadSearchOptionsForBeneficent(copyData);
        }

    }

    function loadSearchOptionsForBeneficent(data) {

        const listContainer = document.getElementById('dropdown-list-beneficent');
        listContainer.innerHTML = ""

        data.forEach(element => {

            const option = document.createElement('div')
            const hr = document.createElement('hr')
            hr.setAttribute('class', 'line')

            option.setAttribute('class', 'dropdown-option');
            option.setAttribute('value', element.ID);
            option.textContent = element.firstname + " " + element.lastname;

            // console.log(option);

            listContainer.appendChild(option);
            listContainer.appendChild(hr)


        });

        // const selctOption = document.querySelector('.dropdown-option');
        // const selectProject = document.getElementById('select-project');
        // const selectProjectValue = document.getElementById('select-project-value');

        listContainer.addEventListener('click', selectBeneficents)
    }

    function selectBeneficents(event) {

        const selectBeneficent = document.getElementById('select-beneficent');
        const selectBeneficentValue = document.getElementById('select-beneficent-value');
        if (event.target.classList.contains('dropdown-option')) {
            let available = false;
            let value = selectBeneficentValue.getAttribute("value");
            let content = selectBeneficent.getAttribute("value");

            if (value) {
                // console.log(value.split(", ").includes(event.target.getAttribute('value')));

                available = value.split(", ").includes(event.target.getAttribute('value'));
            }

            if (!available) {

                content = content ? content + ", " + event.target.textContent : event.target.textContent;
                selectBeneficent.setAttribute('value', content);

                // console.log('project Value ', value);
                value = value ? value + ", " + event.target.getAttribute('value') : event.target.getAttribute('value');
                selectBeneficentValue.setAttribute('value', value)

            }

        }
    }

    function validateForm() {
        let name = document.getElementById('select-pname').value.length > 0;
        let des = document.getElementById('select-description').value.length > 0;
        let button = document.getElementById('submit');

        if(name && des) {
            button.disabled = false;
        } else {
            button.disabled = true;
        }


    }
</script>