<?php

include_once 'db.php';

$sql = "SELECT id, CONCAT(ime, ' ', prezime) AS punoIme FROM authors";
$authors = fetch($sql, $connection, true);

if (isset($_POST['autor'])) {
    //koristim ID autora i iz DB dovlacim samo njegove postove i ispisujem ih na stranica
    $authorId = ($_POST['autor']);

    $sql = "SELECT p.id, title, body, created_at, author_id, a.ime, a.prezime FROM posts AS p
            INNER JOIN authors AS a
            ON p.author_id = a.id
            WHERE a.id = $authorId";
    $posts = fetch($sql, $connection, true);
    //Ukoliko nije selektovan poseban autor iz dropdown menija, dovlacim sve postove i njih ispisujem na stranici
} else if ($_POST['autor'] == 0) {
    $sql = "SELECT p.id, title, body, created_at, author_id, a.ime, a.prezime FROM posts AS p
            INNER JOIN authors AS a
            ON p.author_id = a.id
            ORDER BY created_at DESC";
    $posts = fetch($sql, $connection, true);
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
                <!-- filtriranje radi, ali uvek nakon selekta mi vraca na default vrednost (All authors) -->
                <form method="post" id="authorFilter" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <!-- dobijam Id autora -->
                    <select name="autor" onchange="document.getElementById('authorFilter').submit()">
                        <option value="0" selected>
                            All authors:
                        </option>

                        <?php foreach ($authors as $author) {
                            $punoIme = $author['punoIme'];
                            $authorId = $author['id']
                        ?>
                            <option value="<?php echo "$authorId" ?>">
                                <?php echo $punoIme ?>
                            </option>
                        <?php
                        };
                        ?>
                    </select>
                </form>

                <div class="blog-post">
                    <?php
                    foreach ($posts as $post) {
                        $postId = $post['id'];
                        $imeAutora = $post['ime'] . " " . $post['prezime'];
                    ?>
                        <h2 class="blog-post-title">
                            <!-- setujem ID posta u svaki link kako bih kasnije znao koji post cu prikazati -->
                            <a href="single-post.php?post_id=<?php echo $postId ?>">
                                <?php echo $post['title']; ?>
                            </a>
                        </h2>
                        <p class="blog-post-meta"> <?php echo $post['created_at']; ?> by <a href="#"> <?php echo $imeAutora ?> </a>
                        </p>
                        <p> <?php echo $post['body'] ?> </p>

                    <?php
                    };
                    ?>

                </div>

                <nav class="blog-pagination">
                    <a class="btn btn-outline-primary" href="#">Older</a>
                    <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
                </nav>
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
