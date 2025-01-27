<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/DeleteModel.css">

    </script>
</head>



<body>
    <div
        class="del-modal-overlay" id="deleteModel">
        <div class="del-modal-content" onclick="event.stopPropagation()">
          

            <form action="/add-sentdonation" method="post" class="del-form" onsubmit="return submitDeleteform()">
                <input type="text" hidden name = 'ID' id='del-id'>
               <div class="delMsg">
                <h4>Do you want to delete the sent donation ?</h4>
               </div>
               <div class="option-btn ">
                <button onclick="closeDelModel()" class="opt no" type="button">No</button>
                <button name="del-submit" class="opt yes" id="del-submit" type="submit">Yes</button>
                <button
                            style="display: none;"
                            id="del-submiting"
                            disabled="true"
                            class="opt yes"> Yes
                        </button>
               </div>
               

            </form>
        </div>
    </div>
    </div>
</body>

</html>

<script>
    function closeDelModel() {
        document.getElementById('deleteModel').style.display = 'none'
        // console.log(document.getElementById('del-id').value);
        
    }

    function submitDeleteform(){
        let button = document.getElementById('del-submit');
        let button2 = document.getElementById('del-submiting');
        document.querySelector('.no').setAttribute('disabled', true);
        button.style.display = 'none';
        button2.style.display = 'block';
        return true;
    }
</script>