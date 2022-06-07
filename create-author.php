<?php

include_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $pol = $_POST['pol'];

    $sql = "INSERT INTO authors (ime, prezime, pol)
    VALUES ('$ime', '$prezime', '$pol')";
    $statement = $connection->prepare($sql);
    $statement->execute();

    header('Location:./posts.php');
};

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Vivify Blog</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="styles/blog.css" rel="stylesheet">
    <link href="styles/styles.css" rel="stylesheet">

</head>

<body>

    <?php
    include_once "header.php";
    ?>

    <main role="main" class="container">
        <div class="row">
            <div class="col-sm-8 blog-main">
                <h2>Create author</h2>

                <form method="post" action="create-author.php">
                    <div class="blog-post">
                        <label for="title">Ime:</label>
                        <input type="text" name="ime" required>
                        <label for="body">Prezime:</label>
                        <input type="text" name="prezime" required></input>
                        <form method="post" action="create-author.php">
                            <div class="radioBtn">
                                <label>Pol:</label> <br>
                                <input type="radio" id="male" name="pol" value="M" required></input>
                                <label for="male">M</label>
                                <input type="radio" id="female" name="pol" value="Z" required></input>
                                <label for="female">Ž</label>
                            </div>
                        </form>
                        <button type="submit" class="btn-primary">Submit</button>
                    </div>
                </form>
            </div>

            <?php
            include_once "sidebar.php";
            ?>

        </div>
    </main>

    <?php
    include_once "footer.php";
    ?>

</body>

</html>
