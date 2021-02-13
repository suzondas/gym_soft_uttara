

<!DOCTYPE html>
<html>
<head>
    <base href="https://attendance.door.fitnessplusbd.com/tad-php/">
    <title>Page Title</title>
    <link rel="stylesheet" type="text/css" href="scripts/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="scripts/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <script src="scripts/jquery.js"></script>
    <script src="scripts/angular.min.js"></script>
    <script src="scripts/ng-route.js"></script>
    <script src="scripts/ng-animate.js"></script>
    <script src="scripts/bootstrap.js"></script>
    <script src="scripts/bootstrap-datepicker.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</head>

<body ng-app="myApp" style="padding:50px;">

<h2>Attendance Management</h2>
<table class="table" style="width:400px;">
    <tr>
        <td><a href="newEntry">
                <button>New Entry</button>
            </a></td>
        <td><a href="searchUser">
                <button>Search User</button>
            </a></td>
        <td><a href="reports">
                <button>Report</button>
            </a></td>
<!--
        <td><form action="logout.php" method="get"><input type="submit" value="Logout"></form>
        </td>-->
    </tr>
</table>

<div ng-view></div>

<script src="scripts/app.js"></script>
<script>

</script>


</body>
</html>