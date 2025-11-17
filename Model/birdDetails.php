<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bird Details</title>
    <link rel="stylesheet" href="CSS/birdDetail.css">
</head>
<body> 
    
    <div class="bird"> 
        <h1>SPECIES</h1>
    </div>
    <div class="type-container">
        <div class="type">
            <?php if (!empty($bird)): ?>
                <img src="<?php echo htmlspecialchars($bird->image); ?>" alt="<?php echo htmlspecialchars($bird->bird_name); ?>">
                <h2><?php echo htmlspecialchars($bird->bird_names); ?></h2>
                <p><?php echo htmlspecialchars($bird->bird_description); ?></p>
                <p><strong>Habitat:</strong> <?php echo htmlspecialchars($bird->bird_habitat); ?>  </p>
                <p><strong>Season:</strong> <?php echo htmlspecialchars($bird->bird_season); ?></p>
                <p><strong>Food Habit:</strong> <?php echo htmlspecialchars($bird->food_habit); ?></p>
                <p><strong>Extinction Level:</strong> <?php echo htmlspecialchars($bird->extinction_level); ?></p>
                <p><strong>Scientific Name:</strong> <?php echo htmlspecialchars($bird->scientific_name); ?></p>

            <?php else: ?>
                <p>Bird Not Found!</p> 
            <?php endif; ?>
            <a href="index.php?command=viewSpecies">Back to Bird list</a>
        </div>
    </div>
</body>
</html>
