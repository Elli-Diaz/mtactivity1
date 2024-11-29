<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        * {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div>
        <h1>Employee Data</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Department</th>
                <th>Company</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Hired Date</th>
                <th>Phone Number</th>
                <th>Job Title</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <tr>
                @foreach($employees as $employee)
                <td>{{$employee['id']}}</td>
                <td>{{$employee['department_id']}}</td>
                <td>{{$employee['company_id']}}</td>
                <td>{{$employee['first_name']}}</td>
                <td>{{$employee['last_name']}}</td>
                <td>{{$employee['email']}}</td>
                <td>{{$employee['phone_number']}}</td>
                <td>{{$employee['job_title']}}</td>
                <td>{{$employee['hire_date']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
        </div>
    </div>
</body>

</html>