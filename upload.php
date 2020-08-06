<?php
// Check request type

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // hardcoded auth (A+ security)
    if ($_POST['password'] == "password" && getimagesize($_FILES['file']['tmp_name']))
    {
        var_dump($_FILES);

        // Grab extension
        $e =  strtolower(pathinfo(basename($_FILES["file"]["name"]),PATHINFO_EXTENSION));

        // Generate image name and check for duplicates
        $v = substr(str_shuffle(MD5(microtime())), 0, 10);
        while (file_exists("data/$v.$e"))
        {
            $v = substr(str_shuffle(MD5(microtime())), 0, 10);
        }

        move_uploaded_file($_FILES['file']['tmp_name'], "data/$v.$e");

        // Redirect to image
        header("Location: https://localhost/image/?v=$v");
        die();
    }
}?>


<html>
    <head>
        <title>Upload</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    </head>
    <body>
        <br>
        <div class = "row">
            <div class="col s12 m4 offset-m4">
                <form method="post" class="card" enctype="multipart/form-data">
                    <div class="card-action teal lighten-1 white-text">
                        <h3>Upload</h3>
                    </div>
                    <div class="card-content">
                        <div class="form-field">
                            <label for="file">Image:</label><br><br>
                            <input type="file" id="file" name="file" />
                        </div><br>
                        <div class="form-field">
                            <label for="file">Password:</label>
                            <input type="password" id="password" name="password" />
                        </div><br>
                        <div class="form-field">
                            <button class="btn-large waves-effect waves-dark" style="width:100%">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
