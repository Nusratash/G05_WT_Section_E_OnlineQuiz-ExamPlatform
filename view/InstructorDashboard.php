<?php

?>
<html>

<head>
    <title>INSTRUCTOR DASHBOARD</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th,td { border: 1px solid black; padding: 8px; text-align: left; }
        .btn-active { background-color: #4CAF50; color: white; }
    </style>
</head>

<body>
    <form action="CreateQuiz.php" method="POST">
        <table>
            <tr>
                <td>
                    <input type="submit" value="Create">
                </td>
                <td>
                    <input type="text" name="search_text" placeholder="Enter the search ">
                </td>
                <td>
                    <input type="submit" value="Search">
                </td>
            </tr>
        </table>
    </form>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</body>
</html>