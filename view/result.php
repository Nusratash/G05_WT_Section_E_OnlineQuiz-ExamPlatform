<!DOCTYPE html>
<html lang="en" style="background-color: black; color: white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            border-collapse: collapse;
        }
        td{
            border: 1px solid white;
        }
    </style>
</head>
<body>
    <h1>Result</h1>
    <table>
        <tr>
            <td colspan="2">Question-1</td>
        </tr>
        <tr>
            <td>Score: [student_score]</td>
            <td>Status: [pass/fail]</td>
        </tr>
        <tr>
            <td colspan="2">Your Answer: [Answer given by student]</td>
        </tr>
        <tr>
            <td colspan="2">Correct Answer: [Correct answer from db]</td>
        </tr>
    </table>
</body>
</html>