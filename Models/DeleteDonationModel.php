<html>

<head>
    <link rel="stylesheet" href="Assets/CSS/DeleteModel.css">

</head>



<body>
    <div
        class="del-modal-overlay" id="deleteModel">
        <div class="del-modal-content" onclick="event.stopPropagation()">


            <form action="/#" method="post" class="del-form">
                <input type="text" hidden name='ID' id='del-id'>
                <div class="delMsg">
                    <h4>Do you want to delete the donation ?</h4>
                </div>
                <div class="option-btn ">
                    <button onclick="closeDelModel()" class="opt no" type="button">No</button>
                    <button class="opt yes" type="submit">Yes</button>
                </div>


            </form>
        </div>
    </div>
</body>

</html>

<script>
    function closeDelModel() {
        document.getElementById('deleteModel').style.display = 'none'
        // console.log(document.getElementById('del-id').value);

    }
</script>