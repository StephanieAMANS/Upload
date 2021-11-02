<?php

    $errorMessages = [];

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $uploadDir = 'public/';
    $newPicture = uniqid() .basename($_FILES['picture']['name']);
    $extension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
    $extensions_ok = ['jpg','webp','png', 'gif'];
    $maxFileSize = 1000000;
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $age = $_POST['age'];

    if( (!in_array($extension, $extensions_ok )))
    {
        $errorMessages[] = 'Veuillez sélectionner une image de type Jpg ou Webp ou Png ou Gif!';
    }

    if( file_exists($_FILES['picture']['tmp_name']) && filesize($_FILES['picture']['tmp_name']) > $maxFileSize)
    {
        $errorMessages[] = "Votre fichier doit faire moins de 1M !";
    }

    if(empty($errorMessages)) {
        //var_dump($errorMessages);
        move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir . $newPicture);
        //var_dump($uploadDir . $newPicture);die;
    }
    if (empty($firstname) || empty($lastname) || empty($age)) {
        $errorMessages[] = "Merci de remplir tous les champs";
        //var_dump($errorMessages);die;
    }
    if (isset($_POST['delete'])) {
        if(file_exists($newPicture)) {
            unlink($newPicture);
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="firstname">Enter your firstname</label>
        <input type="text" name="firstname" id="firstname"><br>
        <label for="lastname">Enter your lastname</label>
        <input type="text" name="lastname" id="lastname"><br>
        <label for="age">Enter your age</label>
        <input type="text" name="age" id="age"><br>
        <label for="imageUpload">Upload an profile image</label>
        <input type="file" name="picture" id="imageUpload" />
        <button name="send">Send</button>
        <button name="delete">Delete</button>
    </form>
    <img src="<?= $uploadDir . $newPicture; ?>" alt="img">
</body>
</html>


