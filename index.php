<?php
    echo "<title>Philippine Skywatchers</title>"; 
    echo "<div align='CENTER'>";
        include_once('HTML/header.html');
    echo "</div>";

    echo "<div>";                
        include_once("Controller/controller.php");
        $controller = new Controller();
        $controller->getPage();    
    echo "</div>";

    echo "<div align='CENTER'>";
        include_once('HTML/footer.html');
    echo "</div>";
?>