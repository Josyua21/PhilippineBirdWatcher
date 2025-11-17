<!DOCTYPE html>
<html>
<head>
    <title>Philippine Watcher</title>
    <link rel="stylesheet" href="CSS/viewBird.css">
</head>
<body>
    <!-- Search Form -->
    <form method="GET" action="index.php" style="text-align: center; margin-top: 50px;">
        <input type="hidden" name="command" value="searchBird1">
        <input type="text" name="search" placeholder="Search Species" 
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
               style="padding: 8px; width: 300px;">
        <button type="submit" style="padding: 8px 16px; color: #3C2415;">Search</button>
    </form>

    <h1>Philippine Bird</h1>

    <?php if (empty($bird)): ?>
        <p style="text-align: center; color: red; margin-top: 50px;">
            No results found for your search. Please try again.
        </p>
    <?php else: ?>
        <table>
        <thead>
        <tr>
            <th width="15%" align="center">Image</th>
            <th width="15%" align="center">Bird Number</th>
            <th width="15%" align="center">Bird Name</th>
            <th width="55%" align="center">Bird Description</th>
            <th width="15%" align="center">Habitat</th>
            <th width="15%" align="center">Season's</th>
            <th width="15%" align="center">Food Habit</th>
            <th width="15%" align="center">Extinction Level</th>
            <th width="15%" align="center">Scientific Name</th>
            <th width="15%" align="center">Actions</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th width="15%"align="center">Image</th>
            <th width="15%"align="center">Bird Number</th>
            <th width="15%"align="center">Bird Name</th>
            <th width="55%"align="center">Bird Description</th>
            <th width="15%"align="center">Habitat</th>
            <th width="15%"align="center">Season's</th>
            <th width="15%"align="center">Food Habit</th>
            <th width="15%"align="center">Extinction Level</th>
            <th width="15%"align="center">Scientific Name</th>
            <th width="15%"align="center">Actions</th>
        </tr>
    </tfoot>
            <tbody>
                <?php foreach ($bird as $birds): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($birds->image); ?>" alt="Bird Image" style="width: 150px;"></td>
                        <td><?php echo htmlspecialchars($birds->bird_name); ?></td>
                        <td><?php echo htmlspecialchars($birds->bird_names); ?></td>
                        <td><?php echo htmlspecialchars($birds->bird_description); ?></td>
                        <td><?php echo htmlspecialchars($birds->bird_habitat); ?></td>
                        <td><?php echo htmlspecialchars($birds->bird_season); ?></td>
                        <td><?php echo htmlspecialchars($birds->food_habit); ?></td>
                        <td><?php echo htmlspecialchars($birds->extinction_level); ?></td>
                        <td><?php echo htmlspecialchars($birds->scientific_name); ?></td>
                        <td>
                            <a 
                                href="index.php?command=editBird&bird_name=<?php echo urlencode($birds->bird_name); ?>" 
                                style="text-decoration: none; color: #3C2415;" 
                                onclick="return confirm('Are you sure you want to edit this record?');">Edit</a> 
                            | 
                            <a 
                                href="index.php?command=deleteBird&bird_name=<?php echo urlencode($birds->bird_name); ?>" 
                                style="text-decoration: none; color: #840000;" 
                                onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
