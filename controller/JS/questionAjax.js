function openModal() {
    document.getElementById("modalOverlay").style.display = "flex";
}
function closeModal() {
    document.getElementById("modalOverlay").style.display = "none";
}
function deleteQuiz(quizId) {
    let confirmDelete = confirm("Are you sure to delete this quiz?");
    if (confirmDelete == false) {
        return;
    }
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../Controller/DeleteQuiz.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                if (this.responseText.trim() == "Deleted") {
                    document.getElementById("quiz_row_" + quizId).remove();
                } else {
                    alert("Delete Failed");
                }
            }
        }
    };
    xhttp.send("quiz_id=" + quizId);
}
function toggleQuizStatus(quizId) {
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../Controller/ToggleQuizStatus.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                try {
                    let response = JSON.parse(this.responseText);
                    if (response.success == true) {
                        if (response.status == "published") {
                            document.getElementById("status_" + quizId).innerHTML = "Published";
                            document.getElementById("toggle_btn_" + quizId).innerHTML = "Unpublish";
                        } else {
                            document.getElementById("status_" + quizId).innerHTML = "Draft";
                            document.getElementById("toggle_btn_" + quizId).innerHTML = "Publish";
                        }
                    } else {
                        alert("Cannot publish quiz without questions");
                    }
                } catch (error) {
                    console.log(error);
                    alert("Status Toggle Failed");
                }
            }
        }
    };
    xhttp.send("quiz_id=" + quizId);
}
function deleteQuestion(questionId) {
    let confirmDelete = confirm("Are you sure to delete this question?");
    if (confirmDelete == false) {
        return;
    }
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../Controller/DeleteQuestion.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                if (this.responseText.trim() == "Deleted") {
                    document.getElementById("question_row_" + questionId).remove();
                } else {
                    alert("Delete Failed");
                }
            }
        }
    };
    xhttp.send("question_id=" + questionId);
}
function editQuestion(questionId) {
    let question = document.getElementById("question_text_" + questionId).innerHTML.trim();

    let option1Cell = document.getElementById("option1_" + questionId);
    let option2Cell = document.getElementById("option2_" + questionId);
    let option3Cell = document.getElementById("option3_" + questionId);
    let option4Cell = document.getElementById("option4_" + questionId);

    let option1 = option1Cell.innerHTML.trim();
    let option2 = option2Cell.innerHTML.trim();
    let option3 = option3Cell.innerHTML.trim();
    let option4 = option4Cell.innerHTML.trim();

    let optionId1 = option1Cell.getAttribute("data-option-id");
    let optionId2 = option2Cell.getAttribute("data-option-id");
    let optionId3 = option3Cell.getAttribute("data-option-id");
    let optionId4 = option4Cell.getAttribute("data-option-id");

    let correctAnswer = document.getElementById("correct_option_" + questionId).innerHTML.trim();

    document.getElementById("question_text_" + questionId).innerHTML =
        "<input type='text' id='edit_question_" + questionId + "' value=\"" + question + "\">";

    document.getElementById("option1_" + questionId).innerHTML =
        "<input type='text' id='edit_option1_" + questionId + "' value=\"" + option1 + "\">" +
        "<input type='hidden' id='edit_optionid1_" + questionId + "' value='" + optionId1 + "'>";

    document.getElementById("option2_" + questionId).innerHTML =
        "<input type='text' id='edit_option2_" + questionId + "' value=\"" + option2 + "\">" +
        "<input type='hidden' id='edit_optionid2_" + questionId + "' value='" + optionId2 + "'>";

    document.getElementById("option3_" + questionId).innerHTML =
        "<input type='text' id='edit_option3_" + questionId + "' value=\"" + option3 + "\">" +
        "<input type='hidden' id='edit_optionid3_" + questionId + "' value='" + optionId3 + "'>";

    document.getElementById("option4_" + questionId).innerHTML =
        "<input type='text' id='edit_option4_" + questionId + "' value=\"" + option4 + "\">" +
        "<input type='hidden' id='edit_optionid4_" + questionId + "' value='" + optionId4 + "'>";

    let selected1 = "", selected2 = "", selected3 = "", selected4 = "";
    if (correctAnswer == option1) { selected1 = "selected"; }
    else if (correctAnswer == option2) { selected2 = "selected"; }
    else if (correctAnswer == option3) { selected3 = "selected"; }
    else { selected4 = "selected"; }

    document.getElementById("correct_option_" + questionId).innerHTML =
        "<select id='edit_correct_" + questionId + "'>" +
        "<option value='1' " + selected1 + ">A</option>" +
        "<option value='2' " + selected2 + ">B</option>" +
        "<option value='3' " + selected3 + ">C</option>" +
        "<option value='4' " + selected4 + ">D</option>" +
        "</select>";

    document.getElementById("action_" + questionId).innerHTML =
        "<button onclick='saveQuestion(" + questionId + ")'>Save</button>";
}
function saveQuestion(questionId) {
    let question = document.getElementById("edit_question_" + questionId).value;
    let option1 = document.getElementById("edit_option1_" + questionId).value;
    let option2 = document.getElementById("edit_option2_" + questionId).value;
    let option3 = document.getElementById("edit_option3_" + questionId).value;
    let option4 = document.getElementById("edit_option4_" + questionId).value;
    let optionId1 = document.getElementById("edit_optionid1_" + questionId).value;
    let optionId2 = document.getElementById("edit_optionid2_" + questionId).value;
    let optionId3 = document.getElementById("edit_optionid3_" + questionId).value;
    let optionId4 = document.getElementById("edit_optionid4_" + questionId).value;
    let correctOption = document.getElementById("edit_correct_" + questionId).value;

    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../Controller/UpdateQuestion.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                try {
                    let response = JSON.parse(this.responseText);
                    if (response.success) {
                        document.getElementById("question_text_" + questionId).innerHTML = response.question;
                        document.getElementById("option1_" + questionId).innerHTML = response.option1;
                        document.getElementById("option1_" + questionId).setAttribute("data-option-id", response.optionId1);
                        document.getElementById("option2_" + questionId).innerHTML = response.option2;
                        document.getElementById("option2_" + questionId).setAttribute("data-option-id", response.optionId2);
                        document.getElementById("option3_" + questionId).innerHTML = response.option3;
                        document.getElementById("option3_" + questionId).setAttribute("data-option-id", response.optionId3);
                        document.getElementById("option4_" + questionId).innerHTML = response.option4;
                        document.getElementById("option4_" + questionId).setAttribute("data-option-id", response.optionId4);
                        document.getElementById("correct_option_" + questionId).innerHTML = response.correct_answer;
                        document.getElementById("action_" + questionId).innerHTML =
                            "<button onclick='editQuestion(" + questionId + ")'>Edit</button>" +
                            "<button onclick='deleteQuestion(" + questionId + ")'>Delete</button>";
                    } else {
                        alert("Save Failed: " + (response.error || "Unknown error"));
                    }
                } catch (e) {
                    console.log(e);
                    alert("Save Failed");
                }
            }
        }
    };
    xhttp.send(
        "question_id=" + questionId +
        "&question=" + encodeURIComponent(question) +
        "&option1=" + encodeURIComponent(option1) +
        "&option2=" + encodeURIComponent(option2) +
        "&option3=" + encodeURIComponent(option3) +
        "&option4=" + encodeURIComponent(option4) +
        "&option_id1=" + encodeURIComponent(optionId1) +
        "&option_id2=" + encodeURIComponent(optionId2) +
        "&option_id3=" + encodeURIComponent(optionId3) +
        "&option_id4=" + encodeURIComponent(optionId4) +
        "&correct_option=" + correctOption
    );
}