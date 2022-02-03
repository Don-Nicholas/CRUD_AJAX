<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <title>Server Side DataTable CRUD Operations</title>
  </head>
  <body>
  <div class="row mt-2">
        <div class="col-sm-12">
            <div class="container">
                <div class="row my-5">
                    <div class="col-sm-12 text-center">
                        <h1>Jobs CRUD Operation</h1>
                    </div>
                </div>
                <button class="btn btn-primary font-bold mb-3" id="add_button" data-bs-toggle="modal" data-bs-target="#insertJobModal">Add Job</button>
                <table class="table table-hover mb-5" id="jobstable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Company Name</th>
                            <th>Company Location</th>
                            <th>Salary</th>
                            <th>Job Types</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Insert Modal -->
    <div class="modal fade" id="insertJobModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <form method="post" id="jobForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Insert Job Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" id="company_name" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="company_location" class="form-label">Company Location</label>
                        <input type="text" class="form-control" name="company_location" id="company_location" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="text" class="form-control" name="salary" id="salary" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="job_types" class="form-label">Job Types</label>
                        <textarea class="form-control" name="job_types" id="job_types" rows="3"></textarea>
                    </div>
                </div>
                <div class="model-footer m-3">
                    <input type="hidden" name="job_id" id="job_id">
                    <input type="hidden" name="operation" id="operation">
                    <input type="submit" name="action" id="action" class="btn btn-primary" value="Add">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->

    <script type="text/javascript">
        $('document').ready(function() {
            $('#add_button').click(function() {
                $('#jobForm')[0].reset();
                $('.modal-title').text("Add Job Details");
                $('#action').val("Add");
                $('#operation').val("Add");
            });

            var dataTable = $('#jobstable').DataTable({
                "paging":true,
                "pageLength":5,
                "lengthChange": false,
                "processing":true,
                "serverSide":true,
                "order":[],
                "info":true,
                "ajax":{
                    url:"fetch.php",
                    type:"POST",
                },
                "columnDefs":[
                    {
                        "target":[0, 3, 4],
                        "orderTable":false,
                    },
                ],
            });

            $(document).on('submit', '#jobForm', function(event) {
                event.preventDefault();
                var id = $("#id").val();
                var title = $("#title").val();
                var company_name = $("#company_name").val();
                var company_location = $("#company_location").val();
                var salary = $("#salary").val();
                var jobTypes = $("#job_types").val();

                if(title != '' && company_name != '' && company_location != '' && salary != '' && jobTypes != '')
                {
                    $.ajax({
                        url:"insert.php",
                        method:"POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $("#jobForm")[0].reset();
                            $("#insertJobModal").modal('hide');
                            dataTable.ajax.reload();
                        }
                        
                    });
                }
                else {
                    alert("Title, Company Name, Company Location, Salary and Job Types are Required!");
                }
            });


            $(document).on('click', '.update', function() {
            var job_id = $(this).attr("id");
            $.ajax({
                url:"fetch_single.php",
                method:"POST",
                data: {id: job_id},
                dataType: "json",
                success: function(data)
                {
                    $("#insertJobModal").modal('show'),
                    $("#job_id").val(data.id),
                    $("#title").val(data.title),
                    $("#company_name").val(data.company_name),
                    $("#company_location").val(data.company_location),
                    $("#salary").val(data.salary),
                    $("#job_types").val(data.job_types),
                    $('#action').val("Save"),
                    $("#operation").val("Edit")
                }
            });
        });

        $(document).on('click', '.delete', function() {
            var job_id = $(this).attr("id");
        
            if(confirm("Are you sure you want to delete this job?"))
            {
                $.ajax({
                    url: "delete.php",
                    method: "POST",
                    data: {job_id: job_id},
                    success: function(data) {
                        dataTable.ajax.reload();
                    }
                });
            }
            else 
            {
                return false;
            }
        });


        });

    </script>
  </body>
</html>



<!-- https://www.youtube.com/watch?v=azoMNIISQO4&t=401s&ab_channel=freeCodeCamp.org -->