<?php
include_once "db.php";

//uzimam ID posta iz URL-a
$postId = $_GET['post_id'];

//dovlacim samo post sa zadatim URL-om
$sql = "SELECT p.id, title, body, created_at, author_id, a.ime, a.prezime FROM posts AS p
INNER JOIN authors AS a
ON p.author_id = a.id
WHERE p.id = $postId";
$post = fetch($sql, $connection);

$imeAutora = $post['ime'] . " " . $post['prezime'];

//Dovlacim sve komentare vezane za ovaj post
$sql = "SELECT * FROM comments AS c
WHERE c.post_id = $postId";
$comments = fetch($sql, $connection, true);

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
                <div class="blog-post">
                    <h2 class="blog-post-title"><?php echo $post['title'] ?></h2>
                    <p class="blog-post-meta"><?php echo $post['created_at'] ?> by <a href="#"><?php echo $imeAutora ?></a></p>
                    <p><?php echo $post['body'] ?></p>
                </div>
                <ul>
                    <?php
                    foreach ($comments as $comment) { ?>
                        <li>Autor: <?php echo $comment['author'] ?> <br>
                            <?php echo $comment['TEXT'] ?>
                        </li>
                        <hr>
                    <?php
                    }
                    ?>
                </ul>
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
