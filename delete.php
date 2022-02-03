<?php 
    include('connection.php');
    include('function.php');

    if(isset($_POST['job_id']))
    {
        $query = "DELETE FROM tbl_jobs WHERE id = ".$_POST['job_id']."";
        $statement= $connection->prepare($query);
        $result = $statement->execute();
    }