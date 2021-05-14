<!DOCTYPE html>

<?php
    session_start();

    if ($_SESSION["authorised"] != 1){
        header("Location: index.html");
    }
?>


<html>
    <head>
        <title>This is the first</title>
        <link rel="stylesheet" href="Odin.css">
    </head>
    <body style="background-color: rgb(43, 43, 77);">

        <div class="topnav">
            <a class="active" href="PickVideo.php">Home</a>
            <a href=createACC.html>Create an Account</a>
            <a href=logout.php>Logout</a>
        </div> 

        

        <br><br>
        <div style="padding: 15px 32px;margin: auto;background-color:#161618f5;width:400px;length:200px;border-radius:25px;top:15;float:center;"align="center">
            <form action="video.php" method="POST">
                <h1 style="color: grey;text-align: center;">Pick a date to view</h1>
                <label for="date" style="color: grey"><b>Enter Date</b></label>
                <input type="text" placeholder="dd-mm-yyyy" name="date" id="date" required>
                <br><br>
                <button type="submit" >Search</button>
            </form> 
            </div>  
        
        
    </body>
</html>
