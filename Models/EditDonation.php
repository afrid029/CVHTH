<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/AddDonation.css">

    </script>
</head>



<body>
    <div
        class="modal-overlay" id="editModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <!-- <div onclick="handleAdd(false)" class='close'>Close</div> -->
            <div class="banner edit-banner">
                Edit Donation Info
                <div onclick="closeEdit()" class='close'>Close</div>
            </div>

            <form action="/#" method="post" oninput="validateEditForm()" onsubmit="return submitEditform()">
                <div class="div edit-div"> </div>
                <div class="Form edit-Form">

                    <!-- Select Donor -->
                    <div class="FormRow">

                        <input type="text" name="donor" id="edit-donor-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="edit-donor" placeholder="Select Donor" onclick="editOpenSelect(true)" readonly required>

                        <div class="dropdown-container edit-dropdown-container">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 80%" type="text" id="editSearchkey" placeholder="Search Donors">
                            </div>
                            <div class="dropdown-list " id="edit-dropdown-list">
                                <!-- <div class="dropdown-option" value="1">Hi</div>
                                <div class="dropdown-option" value="2">Hello</div>
                                <div class="dropdown-option" value="3">There</div>
                                <div class="dropdown-option" value="4">It is</div> -->
                            </div>

                        </div>

                        <small class="small">Donor is required</small>
                        <!-- <select name="" id="">
                        <input type="text">
                        <option value="" selected hidden>Select a value</option>
                        <option value="">Hello</option>
                        <option value="">Hi</option>
                        <option value="">Hii</option>
                       </select> -->
                    </div>

                    <!-- Amount -->
                    <div class="FormRow">

                        <input
                            type="number"
                            name="amount"
                            placeholder="Donation Amount (Rs)"
                            min="1"
                            id="edit-amount"
                            required />

                        <small class="small">Amount is required</small>
                    </div>

                    <!-- date -->

                    <div class="FormRow">

                        <input
                            type="date"
                            name="date"
                            id="edit-date"
                            placeholder="Donated Date"
                            required />

                        <small class="small">Date is required</small>
                    </div>

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
    const editToday = new Date();
    const editLocalDate = editToday.toLocaleDateString('en-CA');
    // Set the max attribute to today's date
    document.getElementById('edit-date').setAttribute('max', editLocalDate);


    let editDonorResponse;

    function editLoadDonors() {


        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetAllUsers.php?role=' + encodeURIComponent('donor'), true);
        // document.getElementById('loading-spinner').style.display = 'block';
        // const onload = document.getElementById('onrowload');
        // onload.classList.add('onrowload');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // document.getElementById('loading-spinner').style.display = 'none';
                // // document.getElementById('onrowload').style.display = 'none';
                // onload.classList.remove('onrowload');
                editDonorResponse = JSON.parse(xhr.responseText);
                // console.log(editDonorResponse.data);

                const listContainer = document.getElementById('edit-dropdown-list');
                const search = document.getElementById('editSearchkey');
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', editDonorSearchListener)

                editLoadSearchOptions(editDonorResponse.data)

            }
        };

        xhr.send();
    }

    function editDonorSearchListener(event) {

        const key = event.target.value;
        if (key == '') {
            editLoadSearchOptions(editDonorResponse.data)
        } else {
            let copyData = editDonorResponse.data.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
            editLoadSearchOptions(copyData)


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

    function editOpenSelect(value) {
        const select = document.querySelector('.edit-dropdown-container');

        if (!value) {
            select.style.display = 'none';
        } else {
            select.style.display = 'flex';
        }
    }

    function editLoadSearchOptions(data) {


        const listContainer = document.getElementById('edit-dropdown-list');
        listContainer.innerHTML = ""

        data.forEach(element => {
            // console.log(element);
            const option = document.createElement('div')
            const hr = document.createElement('hr')
            hr.setAttribute('class', 'line')

            option.setAttribute('class', 'dropdown-option');
            option.setAttribute('value', element.ID);
            option.textContent = element.firstname + ' ' + element.lastname;

            listContainer.appendChild(option);
            listContainer.appendChild(hr)


        });

        // const selctOption = document.querySelector('.dropdown-option');
        // const selectDonor = document.getElementById('select-donor');
        // const selectDonorValue = document.getElementById('select-donor-value');

        listContainer.addEventListener('click', editSelectDonor)

    }

    function editSelectDonor(event) {

        const selectDonor = document.getElementById('edit-donor');
        const selectDonorValue = document.getElementById('edit-donor-value');

        if (event.target.classList.contains('dropdown-option')) {
            selectDonor.setAttribute('value', event.target.textContent)
            selectDonorValue.setAttribute('value', event.target.getAttribute('value'))
            validateEditForm();

            editOpenSelect(false);

            // console.log(event.target.getAttribute('value'), event.target.textContent);
        }


    }

    function getSingleDonation(ID){
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetSingleData.php?ID='+ID+'&type=' + encodeURIComponent('donation'), true);
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
                document.getElementById("edit-donor").setAttribute('value', data.name);
                document.getElementById("edit-amount").value = data.amount;
                document.getElementById("edit-date").value = data.date;

                validateEditForm();

            }
        };

        xhr.send();
    }

    function validateEditForm() {
        let donor = document.getElementById('edit-donor-value');
        let date = document.getElementById('edit-date');
        let amount = document.getElementById('edit-amount');
        let button = document.getElementById('edit-submit');


        console.log(donor.value, date.value, amount.value.length);



        if (donor.value && date.value && amount.value.length > 0) {
            // console.log('true');

            button.disabled = false;
        } else {
            button.disabled = true;
            // console.log('false');

        }
        //    event.target.style.border = '1px solid green';

    }

    function submitEditform() {
        let button = document.getElementById('edit-submit');
        let button2 = document.getElementById('edit-submiting');
        button.style.display = 'none';
        button2.style.display = 'block';
        return true;
    }
</script>