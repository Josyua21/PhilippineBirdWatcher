<!DOCTYPE html>
<html>
<head>
    <title>Edit Bird</title>
    <script type="text/javascript">
        // Function to preview selected image before upload
        function imagePreview(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("previewImage");
                preview.src = src;
                preview.style.display = "block";
            }
        }
    </script>
    <style type="text/css">
        /* Specific styles for the form */
        .add-bird-form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 600px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }

        .add-bird-form table {
            width: 100%;
            border-collapse: collapse;
        }

        .add-bird-form table td {
            padding: 8px;
        }

        .add-bird-form input[type="text"],
        .add-bird-form textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .add-bird-form input[type="submit"],
        .add-bird-form input[type="reset"] {
            font-size: 16px;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-bird-form input[type="submit"] {
            background-color: #3C2415;
            color: #fff;
            margin-right: 10px;
        }

        .add-bird-form input[type="reset"] {
            background-color: #d0b0c8;
            color: #fff;
        }

        .add-bird-form input[type="submit"]:hover {
            background-color: #d0b0c8;
        }

        .add-bird-form input[type="reset"]:hover {
            background-color: #3C2415;
        }

        .add-bird-form #previewImage {
            display: block;
            margin: 10px auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 150px;
            height: 150px;
        }
    </style>
</head>
<body>
    <h1 style="padding: 8px; text-align: center; color:#3C2415">EDIT SPECIES</h1>
<form class="add-bird-form" action="index.php?command=updateRec" method="post" enctype="multipart/form-data">
    <table align="center" border="0">
        <tr>
            <td>Bird ID</td>
            <td><input type="text" name="bird_name" value='<?php echo $bird[0]->bird_name ?>'></td>
        </tr>
        <tr>
            <td>Bird Name / Species</td>
            <td><input type="text" name="bird_names" value='<?php echo $bird[0]->bird_names ?>'></td>
        </tr>
        <tr>
            <td>Description of Species</td>
            <td><textarea name="bird_description" rows="4"><?php echo $bird[0]->bird_description; ?></textarea></td>
        </tr>
        <tr>
            <td>Habitat</td>
            <td><input type="text" name="bird_habitat" value='<?php echo $bird[0]->bird_habitat; ?>'></td>
        </tr>
        <tr>
            <td>Season</td>
            <td><input type="text" name="bird_season" value='<?php echo $bird[0]->bird_season; ?>'></td>
        </tr>
        <tr>
            <td>Food Habit</td>
            <td><input type="text" name="food_habit" value='<?php echo $bird[0]->food_habit; ?>'></td>
        </tr>
        <tr>
            <td>Extinction Level</td>
            <td><input type="text" name="extinction_level" value='<?php echo $bird[0]->extinction_level; ?>'></td>
        </tr>
        <tr>
            <td>Scientific Name</td>
            <td><input type="text" name="scientific_name" value='<?php echo $bird[0]->scientific_name; ?>'></td>
        </tr>
        <tr>
            <td colspan="2" align="center">Please Upload a Species Image!</td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <!-- Display existing image or a placeholder -->
                <img src='<?php echo $bird[0]->image ?>' id="previewImage" alt='<?php echo $bird[0]->bird_name ?>' width="300" height="300">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <label for="fileToUpload" class="custom-file-button">Upload Image</label>
                <input type="file" name="fileToUpload" id="fileToUpload" onchange="imagePreview(event)" accept="image/*">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" value="Update Record" name="updateRecord">
                <input type="reset" value="Reset">
            </td>
        </tr>
    </table>
</form>
</body>
</html>
