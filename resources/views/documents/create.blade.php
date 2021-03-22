<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.0/css/bulma.css"/>

<form action="/api/documents" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="fileUpload" id="fileUpload">
    <br>
    <input type="submit" class="is-link" name="submit" value="Submit File">
</form>

<?php
    if (isset($_POST['submit']) && isset($_FILES['fileUpload'])) {
        if ($_FILES['fileUpload']['error'] > 0)
            echo "Error!";
        else {
            move_uploaded_file($_FILES['fileUpload']['tmp_name'], './upload/' . $_FILES['fileUpload']['name']);
            echo "Success!<br/>";
        }
    }
?>
