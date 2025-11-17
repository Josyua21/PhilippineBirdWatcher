<?php
class Model
{
    public $db = null;

    function __construct()
    {
        try
        {
            $this->db = new mysqli('localhost', 'root', '', 'bird');
            if ($this->db->connect_error) {
                throw new Exception("Database connection failed: " . $this->db->connect_error);
            }
        }
        catch (Exception $e)
        {
            exit('Database connection could not be established.');
        }
    }

    public function getbirdList()  
    {
        $data = array();
        $queryGetBird = mysqli_query($this->db, "SELECT * FROM tblbird ORDER BY bird_name ASC");

        if ($queryGetBird) {
            while ($getRow = mysqli_fetch_object($queryGetBird)) {                
                $data[] = $getRow;
            }
        } else {
            return "Error: " . $this->db->error;
        }

        return $data;
    }

    public function getBirdDetails($bird_names)
{
    $stmt = $this->db->prepare("SELECT * FROM tblbird WHERE bird_names = ?");
    $stmt->bind_param("s", $bird_names);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_object();
}


public function deleteRecord($bird_name)
{
    // Step 1: Escape the bird_name to prevent SQL injection
    $bird_name = mysqli_real_escape_string($this->db, $bird_name);

    // Step 2: Fetch the image path for the bird to be deleted
    $fetchQuery = "SELECT image FROM tblbird WHERE bird_name = '$bird_name'";
    $result = mysqli_query($this->db, $fetchQuery);

    // Check if the bird record exists
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = $row['image']; // Get the image path from the database

        // Step 3: Check if the image exists and delete it
        if (!empty($imagePath) && file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file from the server
        }

        // Step 4: Delete the bird record from the database
        $deleteQuery = "DELETE FROM tblbird WHERE bird_name = '$bird_name'";
        $deleteResult = mysqli_query($this->db, $deleteQuery);

        // Step 5: Return a message based on the deletion result
        if (!$deleteResult) {
            return "Error deleting record: " . mysqli_error($this->db); // Return an error message
        } else {
            return "Record has been successfully deleted"; // Success message
        }
    } else {
        return "Bird not found or no image associated"; // Record not found
    }
} 

public function updateRecords($bird_name,$bird_names, $bird_description, $imagePath, $bird_habitat, $bird_season, $food_habit, $extinction_level, $scientific_name = null)
{
    // Start the SQL query
    $query = "UPDATE tblbird SET bird_description = ?, bird_names = ?, bird_habitat = ?, bird_season = ?, food_habit = ?, extinction_level = ?";
    $types = "ssssss"; // Corresponding parameter types
    $params = [$bird_description, $bird_names, $bird_habitat, $bird_season, $food_habit, $extinction_level];

    // Add scientific_name if provided
    if ($scientific_name !== null) {
        $query .= ", scientific_name = ?";
        $types .= "s";
        $params[] = $scientific_name;
    }

    // Add image update if a new image is provided
    if ($imagePath) {
        $query .= ", image = ?";
        $types .= "s";
        $params[] = $imagePath;
    }

    // Complete the query with WHERE clause
    $query .= " WHERE bird_name = ?";
    $types .= "s";
    $params[] = $bird_name;

    // Prepare the statement and bind parameters
    $stmt = $this->db->prepare($query);
    $stmt->bind_param($types, ...$params);

    // Execute the query and return the result
    if ($stmt->execute()) {
        return "Record updated successfully.";
    } else {
        return "Error: " . $stmt->error;
    }
}


public function checkImageUpload($imageSize,$imageFileType,$target_file)
    {
		

		$uploadOk = 1;
		$errMsg="1";

		
		
			if($imageSize !== false) 
			{				
				// Check if file already exists
				$uploadOk = 1;
				if (file_exists($target_file)) 
				{
					$errMsg= "Sorry, file already exists.";
					$uploadOk = 0;
				}
				else
				{
					// Check file size
					
					if ($_FILES["fileToUpload"]["size"] > 5000000) 
					{
						var_dump($imageSize);
						$errMsg= "Sorry, your file is too large.";
						$uploadOk = 0;
					}
					// check certain file formats
					else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
						&& $imageFileType != "gif" && $imageFileType != "svg") 
					{
						$errMsg= "Sorry, only JPG, JPEG, PNG, GIF, & SVG files are allowed.";
						$uploadOk = 0;
					}
										
				}
			} 
			else 
			{
				$errMsg= "File is not an image.";
				$uploadOk = 0;
			}


			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) 
			{
				$errMsg= $errMsg;
			
			} 
			else // if everything is ok, try to upload file
			{
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
				{
					$errMsg= "OK";
					
				} 
				else 
				{
					$errMsg= "Sorry, there was an error uploading your file.";
				}
			}		
		return $errMsg;
    }


    public function insertBird($bird_name,$bird_names, $bird_description, $image, $bird_habitat, $bird_season, $food_habit, $extinction_level, $scientific_name)
{
    // Prepared statement for inserting into tblbird
    $stmt = $this->db->prepare("INSERT INTO tblbird (bird_name, bird_names, bird_description, image, bird_habitat, bird_season, food_habit, extinction_level, scientific_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        return "Error: " . $this->db->error;
    }
    $stmt->bind_param("sssssssss", $bird_name, $bird_names, $bird_description, $image, $bird_habitat, $bird_season, $food_habit, $extinction_level, $scientific_name);

    if ($stmt->execute()) {
        return "Record Saved";
    } else {
        return "Error: " . $stmt->error;
    }
}

public function searchBird($bird_name)
{
    // $stmt = statement
    $stmt = $this->db->prepare("SELECT * FROM tblbird WHERE bird_name = ?");
    $stmt->bind_param("s", $bird_name);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_object()) {
        $data[] = $row;
    }
    return $data;
}

public function getSearchBird($search = '') 
{
    $data = [];

    if ($search) {
        // Prepare query with wildcard search for multiple fields
        $searchTerm = '%' . $search . '%';
        $query = $this->db->prepare("
            SELECT * 
            FROM tblbird 
            WHERE bird_names LIKE ? 
            OR bird_name LIKE ?
               
        ");
        $query->bind_param("ss", $searchTerm, $searchTerm);
        $query->execute();

        // Fetch results into an array
        $result = $query->get_result();
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
    } else {
        // Fetch all records if no search term is provided
        $result = $this->db->query("SELECT * FROM tblbird");
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
    }

    return $data;
}

}
?>