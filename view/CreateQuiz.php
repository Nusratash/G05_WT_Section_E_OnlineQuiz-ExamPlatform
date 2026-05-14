<?php
?>
<html>
<head>
    <title>CREATE QUIZ</title>
    <link rel="stylesheet" type="text/css" href="styleqsbuild.css">
</head>
<body>
    <form>
        <table class="no-border">
            <tr>
                <td class="label-cell">Quiz Title:</td>
                <td>
                    <input type="text" name="quiz_title" class="input-field">
                </td>
            </tr>

            <tr>
                <td>Description:</td>
                <td>
                    <input type="text" name="description" class="input-field">
                </td>
            </tr>

            <tr>
                <td>Total Mark:</td>
                <td>
                    <input type="number" name="total_mark" class="input-field">
                </td>
            </tr>

            <tr>
                <td>Time:</td>
                <td>
                    <input type="text" name="quiz_time" class="input-field">
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td class="question_section">
                    <button 
                        type="button" 
                        class="btn-add"
                        onclick="openModal()"
                    >
                        ADD ITEM
                    </button>
                    <div id="questionList"></div>
                    <input 
                        type="submit" 
                        value="SAVE" 
                        class="btn-save"
                    >
                </td>
            </tr>
        </table>
    </form>
    <?php include "questionModal.php"; ?>

</body>
</html>