<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>De Bieb</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        body {
            color: #566787;
            background-color: rgba(67, 93, 125, 0.25);
            font-family: 'Varela Round', sans-serif;
        }
        .btn {
            font-size: 12px;
        }

        .container-fluid{
            padding-left: 0;
            padding-right: 0;
        }

        .card {
            height: 400px;
            margin: 0 auto;
            margin-bottom: 10px;
            float: none;
            width: 400px;
        }
        .table {
            max-height: 100%;
            overflow-x: auto;
        }

        table.table tr th{
            font-size: 15px;
            background-color: #435d7d;
            color: white;
            border-color: black;
            border-width: 1px;
            padding: 5px 5px;
            vertical-align: Middle;
            text-align: center;
            border-right-style: solid;
            border-bottom-style: solid;
            border-left-style: solid;

        }
        table.table tr td {
            border-color: #e9e9e9;
            font-size: 12px;
            padding: 5px 5px;
            height: 45px;
            width: auto;
            vertical-align: Middle;
            border-top-width: 1px;
            border-top-color: #435d7d;
            border-right-width: 1px;
            border-right-color: #435d7d;
            border-right-style: solid;
            border-bottom-width: 1px;
            border-bottom-color: #435d7d;
            border-bottom-style: solid;
            border-left-width: 1px;
            border-left-color: #435d7d;
            border-left-style: solid;

        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background: rgba(249, 249, 249, 0.70);
        }
        table.table-striped tbody tr:nth-of-type(even) {
            background: rgba(249, 249, 249, 0.26);
        }
        table.table-striped.table-hover tbody tr:hover {
            background: #e6e6e6;
        }

        /* Modal styles */
        .modal .modal-dialog {
            max-width: 400px;
        }

        .modal .modal-lg {
            max-width: 900px;
        }
        .modal .modal-1100px {
            max-width: 1100px;
        }
        .modal .modal-header, .modal .modal-body, .modal .modal-footer {
            padding: 10px 30px;
        }


        .modal .modal-content {
            border-radius: 3px;
        }

        .modal .modal-footer {
            border-radius: 0 0 3px 3px;
        }

        .modal .modal-title {
            display: inline-block;

        }

        .modal .form-control {
            border-radius: 2px;
            box-shadow: none;
            border-color: #dddddd;
            font-size: 12px;
        }

        .modal .form-group {
            margin-bottom: 0;
        }

        .modal .btn {

            min-width: 100px;
        }

        .modal form label {
            font-weight: normal;
            font-size: 15px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <img src="./Templates/debieb.png" width="35" height="30" class="d-inline-block align-top" alt="">
        De Bieb</a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="./Leden.php">Leden</a>
            <a class="nav-item nav-link" href="./Boeken.php">Boeken</a>
        </div>
    </div>
</nav>