<h1>Information</h1>

<?php
    if(isset($_GET['message'])){
        echo "<p>".$_GET['message']."</p>";
    }