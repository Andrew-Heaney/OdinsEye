
<?php
    session_start();

    if ($_SESSION["authorised"] != 1){
        header("Location: index.html");
    }
?>

<html>
    <header>
        <title>View Video</title>
        <link rel="stylesheet" href="Odin.css">
    </header>
<body style="background-color: rgb(43, 43, 77);">

    <div class="topnav">
        <a class="active" href="PickVideo.php">Home</a>
        <a href=logout.php>Logout</a>
    </div> 
    
    <?php $date = $_POST["date"]; $file = $_POST["date"].=".mp4";?>
    
    <div style="font-size: 100;color: grey;"><?php echo $date?></div>

    
        <video controls style= "margin:auto;width:50%;">
            <source src = vids/<?php echo $file ?> type='video/mp4'>
            Your browser does not support the video tag.
        </video>
    
</body>
</html>