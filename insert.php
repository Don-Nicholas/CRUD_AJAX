<?php 
    include('connection.php');
    include('function.php');

    

    if(isset($_POST['operation']))
    {
        if($_POST['operation'] == 'Add'){
            $query = "INSERT INTO `tbl_jobs`(`title`, `company_name`, `company_location`, `salary`, `job_types`) VALUES ('".$_POST['title']."', '".$_POST['company_name']."', '".$_POST['company_location']."', '".$_POST['salary']."', '".$_POST['job_types']."')";
            $statement = $connection->prepare($query);
            $result = $statement->execute();

        }

        if($_POST['operation'] == 'Edit')
        {
            $query = "UPDATE tbl_jobs SET id=".$_POST['job_id'].", title = '".$_POST['title']."', company_name = '".$_POST['company_name']."', company_location = '".$_POST['company_location']."', salary = '".$_POST['salary']."', job_types = '".$_POST['job_types']."' WHERE id = ".$_POST['job_id']." ";
            $statement = $connection->prepare($query);
            $result = $statement->execute();
        }
    }