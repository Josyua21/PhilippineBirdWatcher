<?php
class Controller
{
	public $model=null;
	
	function __construct()
	{		
		require_once('Model/model.php');
		$this->model=new Model();
	}
	
	public function getPage()
	{		
		$command=null;

		if(isset($_REQUEST['command']))
			$command=$_REQUEST['command'];

		switch($command)	
		{
			case 'Home':
			{
				include('HTML/Home.html');
				break;

			}
			case 'About':
			{
				include('HTML/About.html');
				break;
			}
			case 'viewSpecies':
				$bird = $this->model->getbirdList();
				include ('Model/viewSpecies.php');
				break;
            case 'Contact':
            {
                include('HTML/Contact.html');
                break;

            }
			case 'viewBird':
				$bird = $this->model->getBirdList();
				include 'Model/viewBird.php';
				break;
			
			case 'Birds':
				{
					include ('Model/addBird.php');
					break;
				}

			case 'editBird':
				{
					$bird_name=$_REQUEST['bird_name'];
										
					$bird=$this->model->searchBird($bird_name);
					
					include 'Model/editBird.php';				
					break;
				}

				case 'birdDetails':
					$bird_names = isset($_GET['bird_names']) ? $_GET['bird_names'] : null;
					if ($bird_names) {
						$bird = $this->model->getBirdDetails($bird_names); // Fetch details using bird_names
						if ($bird) {
							include 'Model/birdDetails.php'; // Display details
						} else {
							echo "Bird not found.";
						}
					} else {
						echo "Invalid Bird Species.";
					}
					break;
				
			
			case 'deleteBird':
                if (isset($_GET['bird_name'])) {
                    $bird_name = $_GET['bird_name'];
                    $result = $this->model->deleteRecord($bird_name); // Call the model's delete method
                    echo "<script>alert('$result'); window.location.href='index.php?command=viewBird';</script>";
                }
                break;
			

				case 'insertBird': 
					{
						$bird_name = $_REQUEST['bird_name'];
						$bird_names = $_REQUEST['bird_names'];
						$bird_description = $_REQUEST['bird_description'];
						$bird_habitat = $_REQUEST['bird_habitat'];
						$bird_season = $_REQUEST['bird_season'];
						$food_habit = $_REQUEST['food_habit'];
						$extinction_level = $_REQUEST['extinction_level'];
						$scientific_name = $_REQUEST['scientific_name'];
						
						$imageUpload = basename($_FILES["fileToUpload"]["name"]);
						$imagePath = "Picture/" . $imageUpload;
						
						// Check file extension and validity
						$imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
						$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
						
						// Call model function to validate image
						$err = $this->model->checkImageUpload($check, $imageFileType, $imagePath);
						
						if ($err == "OK") {
							// Insert bird data including image path
							$result = $this->model->insertBird($bird_name,$bird_names, $bird_description, $imagePath, $bird_habitat, $bird_season, $food_habit, $extinction_level, $scientific_name);
							echo '<script>alert("'.$result.'");</script>';
							
							include 'Model/addBird.php';
						} else {
							echo '<script>alert("'.$err.'");</script>';
						}
						break;
					}					

				case 'updateRec':
					{
						$bird_name = $_REQUEST['bird_name'];
						$bird_names = $_REQUEST['bird_names'];
						$bird_description = $_REQUEST['bird_description'];
						$bird_habitat = $_REQUEST['bird_habitat'];
						$bird_season = $_REQUEST['bird_season'];
						$food_habit = $_REQUEST['food_habit'];
						$extinction_level = $_REQUEST['extinction_level'];
						$scientific_name = $_REQUEST['scientific_name'];
				
						$imagePath = null; // Default to null if no new image is uploaded
				
						// Check if a file was uploaded
						if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["tmp_name"] != "") {
							$imageUpload = basename($_FILES["fileToUpload"]["name"]);
							$imagePath = "Picture/" . $imageUpload;
				
							$imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
							$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				
							// Validate the uploaded image
							$err = $this->model->checkImageUpload($check, $imageFileType, $imagePath);
							if ($err != "OK") {
								echo '<script>alert("' . $err . '");</script>';
								return ;
							}
						} 
				 
						// Update the bird record
						$result = $this->model->updateRecords($bird_name, $bird_names, $bird_description, $imagePath, $bird_habitat, $bird_season, $food_habit, $extinction_level, $scientific_name);
						echo "<script>alert('" . $result . "'); window.location.href='index.php?command=viewBird';</script>";
						break;
					}
					case 'searchBird1':
						// Retrieve search term from GET request or set to empty string
						$search = isset($_GET['search']) ? trim($_GET['search']) : '';
					
						// Call model method to get search results
						$bird = $this->model->getSearchBird($search);
					
						// Include view to display the results
						include 'Model/viewBird.php'; // Ensure this path matches your file structure
						break;
					
						
		}
	}
} 