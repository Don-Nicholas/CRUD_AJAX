<?php 

    include('connection.php');
    include('function.php');

    if(isset($_POST['id']))
    {
        $output = array();

        $statement = $connection->prepare("SELECT * FROM tbl_jobs WHERE id = '".$_POST['id']."' LIMIT 1");
        $statement->execute();
        $result = $statement->fetchAll();

        foreach($result as $row)
        {
            $output['id'] = $row['id'];
            $output['title'] = $row['title'];
            $output['company_name'] = $row['company_name'];
            $output['company_location'] = $row['company_location'];
            $output['salary'] = $row['salary'];
            $output['job_types'] = $row['job_types'];
        }

        echo json_encode($output);
    }
