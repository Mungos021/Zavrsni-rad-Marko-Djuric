<?php

include_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $autorId = $_POST['autor'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $createdAt = date('Y-m-d H:m');

    //Upisujem novi post u DB
    $sql = "INSERT INTO posts (title, body, author_id, created_at)
    VALUES ('$title', '$body', '$autorId', '$createdAt')";
    $statement = $connection->prepare($sql);
    $statement->execute();

    header('Location:./posts.php');
};

$sql = "SELECT id, ime, prezime, pol, CONCAT(ime, ' ' , prezime) as punoIme FROM authors";
$authors = fetch($sql, $connection, true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="styles/blog.css" rel="stylesheet">
    <link href="styles/styles.css" rel="stylesheet">
    <title>Vivify Blog</title>

</head>

<body>

    <?php
    include_once "header.php";
    ?>

    <main role="main" class="container">
        <div class="row">
            <div class="col-sm-8 blog-main">
                <h2>Create new post</h2>

                <form method="post" action="create-post.php">
                    <div class="blog-post">

                        <select name="autor">
                            <option selected="selected">
                                Odaberite autora:
                            </option>

                            <!-- Prolazim kroz niz autora dobavljenih iz baze i za svakog kreiram novi 'option' element unutar 'select' elementa -->
                            <?php foreach ($authors as $author) {
                                // za svakog autora odmah proveravam pol i prema tome dodeljujem novu vrednost u promenljivu $genderClass koja ce se koristiti za dinamicko dodeljivanje klase 'option' elementu
                                // klasa se uspesno i tacno dodeljuje, ali za sada nisam uspeo da pregazim stil
                                $author['pol'] === 'M' ? $genderClass = "male" : $genderClass = "female";
                                $punoIme = $author['punoIme'];
                                $authorId = $author['id']
                            ?>
                                <option class="<?php echo $genderClass ?>" value="<?php echo "$authorId" ?>">
                                    <?php echo $punoIme ?>
                                </option>
                            <?php
                            };
                            ?>
                        </select>
                        <label for="title">Title:</label>
                        <input type="text" placeholder="Enter title" name="title" required>
                        <label for="body">Content:</label>
                        <textarea type="text" placeholder=" Enter content here" name="body" required></textarea>
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
