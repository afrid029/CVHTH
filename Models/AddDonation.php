<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/AddDonation.css">

    </script>
</head>



<body>
    <div
        class="modal-overlay" id="addModel">
        <div class="modal-content" onclick="event.stopPropagation()">
            <!-- <div onclick="handleAdd(false)" class='close'>Close</div> -->
            <div class="banner">
                Receive Donation
                <div onclick="handleAdd(false)" class='close'>Close</div>
            </div>

            <form action="/add-donation" method="post" oninput="validateForm()" onsubmit="return submitLoginform()">
                <div class="div"> </div>
                <div class="Form">

                    <!-- Select Donor -->
                    <div class="FormRow">

                        <input type="text" name="donor" id="select-donor-value" hidden required>
                        <input style="cursor: pointer;" type="text" id="select-donor" placeholder="Select Donor" onclick="openSelect(true)" readonly required>

                        <div class="dropdown-container">
                            <div style="width: 100%;">
                                <input class="search-mobile" style="background-color:rgba(204, 204, 204, 0.79); width: 10%; text-align: center; color: #000000c9; font-weight: 700;" type="text" readonly value="Search">
                                <input class="searchbar-mobile" style="width: 80%" type="text" id="searchkey" placeholder="Search Donors">
                            </div>
                            <div class="dropdown-list" id="dropdown-list">
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
                            id="select-amount"
                            required />

                        <small class="small">Amount is required</small>
                    </div>

                    <!-- date -->

                    <div class="FormRow">

                        <input
                            type="date"
                            name="date"
                            id="select-date"
                            placeholder="Donated Date"
                            required />

                        <small class="small">Date is required</small>
                    </div>

                    <div class="button">
                        <button
                            type="submit"
                            id="submit"
                            name="submit"
                            disabled="true"
                            class="submit"> Add Donation
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
    </div>
</body>

</html>

<script>
    const today = new Date();
    const localDate = today.toLocaleDateString('en-CA');
    // Set the max attribute to today's date
    document.getElementById('select-date').setAttribute('max', localDate);


    let donorResponse;

    function loadDonors() {


        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetAllUsers.php?role=' + encodeURIComponent('addonor'), true);
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

                const listContainer = document.getElementById('dropdown-list');
                const search = document.getElementById('searchkey');
                // search.setAttribute('onclick',`searchOption(${response.data})`)

                search.addEventListener('input', donorSearchListener)

                loadSearchOptions(donorResponse.data)

            }
        };

        xhr.send();
    }

    function donorSearchListener(event) {

        const key = event.target.value;
        if (key == '') {
            loadSearchOptions(donorResponse.data)
        } else {
            let copyData = donorResponse.data.filter((ele) =>
                (ele.firstname + " " + ele.lastname).toUpperCase().includes(key.toUpperCase()));
            loadSearchOptions(copyData)


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

    function openSelect(value) {
        const select = document.querySelector('.dropdown-container');

        if (!value) {
            select.style.display = 'none';
        } else {
            select.style.display = 'flex';
        }
    }

    function loadSearchOptions(data) {


        const listContainer = document.getElementById('dropdown-list');
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

        listContainer.addEventListener('click', selectDonor)

    }

    function selectDonor(event) {

        const selectDonor = document.getElementById('select-donor');
        const selectDonorValue = document.getElementById('select-donor-value');

        if (event.target.classList.contains('dropdown-option')) {
            selectDonor.setAttribute('value', event.target.textContent)
            selectDonorValue.setAttribute('value', event.target.getAttribute('value'))
            validateForm();

            openSelect(false);

            // console.log(event.target.getAttribute('value'), event.target.textContent);
        }


    }



    function validateForm() {
        let donor = document.getElementById('select-donor-value');
        let date = document.getElementById('select-date');
        let amount = document.getElementById('select-amount');
        let button = document.getElementById('submit');


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

    function submitLoginform() {
        let button = document.getElementById('submit');
        let button2 = document.getElementById('submiting');
        button.style.display = 'none';
        button2.style.display = 'block';
        return true;
    }
</script>