<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Species of Birds</title>
    <link rel="stylesheet" href="CSS/bird.css">
    <link rel="icon" href="Picture/logo.png" type="png">
</head>

<body> 
    <div class="bird">
        <h1>PHILIPPINE</h1>
        <h2>BIRDS</h2>
    </div>

    <section class="type-container">
    <?php
    if ($bird) {
        foreach ($bird as $row) {
            $bird_names = htmlspecialchars($row->bird_names); // Use bird_names
            $bird_description = htmlspecialchars($row->bird_description);
            $image = htmlspecialchars($row->image);

            echo "
            <div class='type'>
                <img src='$image' alt='$bird_names Image'>
                <h2><a href='index.php?command=birdDetails&bird_names=" . urlencode($bird_names) . "' style='text-decoration:none; color: #3C2415;'>$bird_names</a></h2>
                <p>$bird_description</p>
            </div>
            ";
        }
    } else {
        echo "<p>No bird species available.</p>";
    }
    ?>
    </section>
</body>
</html>
