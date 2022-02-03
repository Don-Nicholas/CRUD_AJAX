<?php 

    include('connection.php');
    include('function.php');

    $query = '';
    $output = array();
    $query .= "SELECT * FROM tbl_jobs ";

    if(isset($_POST['search']['value']))
    {
        $query .= 'WHERE title LIKE "%'.$_POST['search']['value'].'%" ';
        $query .= 'OR company_name LIKE "%'.$_POST['search']['value'].'%" ';
        $query .= 'OR company_location LIKE "%'.$_POST['search']['value'].'%" ';
        $query .= 'OR salary LIKE "%'.$_POST['search']['value'].'%" ';
        $query .= 'OR job_types LIKE "%'.$_POST['search']['value'].'%" ';
    }

    if(isset($_POST['order']))
    {
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
    }
    else 
    {
        $query .= 'ORDER BY id ASC ';
    }

    if($_POST['length'] != -1)
    {
        $query .= 'LIMIT '.$_POST['start'].', '.$_POST['length'];
    }




    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
    $filtered_rows = $statement->rowCount();
    
    foreach($result as $row) 
    {
        $sub_array = array();

        $sub_array[] = $row['id'];
        $sub_array[] = $row['title'];
        $sub_array[] = $row['company_name'];
        $sub_array[] = $row['company_location'];
        $sub_array[] = $row['salary'];
        $sub_array[] = $row['job_types'];
        $sub_array[] = '<button type="button" name="update" id="'.$row['id'].'" class="btn btn-success btn-sm update" >Update</button>';
        $sub_array[] = '<button type="button" name="delete" id="'.$row['id'].'" class="btn btn-danger btn-sm delete" >Delete</button>';

        $data[] = $sub_array;
    }

    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => $filtered_rows,
        "recordsFiltered" => get_total_all_records(),
        "data" => $data
    );

    echo json_encode($output);
