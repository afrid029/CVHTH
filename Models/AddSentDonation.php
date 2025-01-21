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
                Serve Donation
                <div onclick="handleAdd(false)" class='close'>Close</div>
            </div>

            <form action="/#" method="post" oninput="validateForm()" onsubmit="return submitLoginform()">
            <!-- <form action="/#" method="post"> -->
                <div class="div"> </div>
                <div class="Form">
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

                    </div>

                    <!-- Select Date -->
                    <div class="FormRow">
                        <small style="color: gray; display: flex; width: 100%; font-size: 12px; margin-bottom: 5px; font-family: Lato, serif">Donated Date</small>
                        <input type="date" id="select-date" name="date">
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

                    <div class="button">
                        <button
                            type="submit"
                            id="submit"
                            name="submit"
                            disabled="true"
                            class="submit"> Add
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

                // const listContainer = document.getElementById('dropdown-list-donor');
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

        listContainer.addEventListener('click', selectDonors)

    }

    function selectDonors(event) {

        const selectDonor = document.getElementById('select-donor');
        const selectDonorValue = document.getElementById('select-donor-value');

        if (event.target.classList.contains('dropdown-option')) {
            selectDonor.setAttribute('value', event.target.textContent)
            selectDonorValue.setAttribute('value', event.target.getAttribute('value'))

            openSelect('dropdown-container-donor', false);

            // console.log(event.target.getAttribute('value'), event.target.textContent);
        }
    }

    function loadProjBene() {
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

        selectedBene = beneficent.filter((el) => {
            // console.log(el, value);
            
            return el.project_id === value
        })

        console.log(selectedBene);
        

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

            openSelect('dropdown-container-beneficent', false);

        }

    }

    function validateForm(){
        const donor = document.getElementById('select-donor-value').value.length > 0;
        const date = document.getElementById('select-date').value.length > 0;
        const project = document.getElementById('select-project-value').value.length > 0;
        const beneficent = document.getElementById('select-beneficent-value').value.length > 0;
        const amount = document.getElementById('select-amount').value.length > 0;
        const purpose = document.getElementById('select-purpose').value.length > 0;
        const button = document.getElementById('submit');

        if(donor && date && project && beneficent && amount && purpose){
            button.disabled = false;
        } else {
            button.disabled = true;
        }
    }

    function submitLoginform() {
        let button = document.getElementById('submit');
        let button2 = document.getElementById('submiting');
        button.style.display = 'none';
        button2.style.display = 'block';
        return true;
    }
</script>