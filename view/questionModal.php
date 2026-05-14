<?php
?>
<html>
<head>
</head>
<body>
    <form id="questionModal" class="modal">
        <table class="modal-content">
            <tr class="no-border">
                <th colspan="2">
                    <h2>Question 1</h2>
                </th>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="text" id="question" class="question-input" placeholder="Enter your question">
                </td>
            </tr>
            <tr>
                <th colspan="2">
                    <h2>Options</h2>
                </th>
            </tr>
            <tr>
                <td style="width: 100px; white-space: nowrap;">
                    <input type="radio" id="correct1" name="correct" value="Option 1">
                    <label for="correct1">Correct</label>
                </td>
                <td>
                    <input type="text" id="option1" class="input-field" placeholder="Option 1">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="radio" id="correct2" name="correct" value="Option 2">
                    <label for="correct2">Correct</label>
                </td>
                <td>
                    <input type="text" id="option2" class="input-field" placeholder="Option 2">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="radio" id="correct3" name="correct" value="Option 3">
                    <label for="correct3">Correct</label>
                </td>
                <td>
                    <input type="text" id="option3" class="input-field" placeholder="Option 3">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="radio" id="correct4" name="correct" value="Option 4">
                    <label for="correct4">Correct</label>
                </td>
                <td>
                    <input type="text" id="option4" class="input-field" placeholder="Option 4">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="height: 20px;"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="button" class="btn-add" onclick="addQuestion()">
                        Add
                    </button>

                    <button type="button" class="btn-cancel" onclick="closeModal()">
                        Cancel
                    </button>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>