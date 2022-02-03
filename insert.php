<?php 
    include('connection.php');
    include('function.php');

    

    if(isset($_POST['operation']))
    {
        if($_POST['operation'] == 'Add'){
            $query = "INSERT INTO `tbl_jobs`(`title`, `company_name`, `company_location`, `salary`, `job_types`) VALUES ('".$_POST['title']."', '".$_POST['company_name']."', '".$_POST['company_location']."', '".$_POST['salary']."', '".$_POST['job_types']."')";
            $statement = $connection->prepare($query);
            $result = $statement->execute();

            echo $query;
        }
        if($_POST['operation'] == 'Edit')
        {
            $statement = $connection->prepare("UPDATE tbl_jobs SET id=:id, title = :title, company_name = :company_name, company_location = :company_location, salary = :salary, job_types = :job_types WHERE id = :id ");
            $result = $statement->execute(
                array(
                    ':title' => $_POST['title'], 
                    ':company_name' => $_POST['company_name'], 
                    ':company_location' => $_POST['company_location'], 
                    ':salary' => $_POST['salary'], 
                    ':job_types' => $_POST['job_types'],
                    ':id' => $_POST['id']
                )
            );
        }
    }