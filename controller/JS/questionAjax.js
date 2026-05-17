function openModal() {
    document.getElementById("modalOverlay").style.display = "flex";
}
function closeModal() {
    document.getElementById("modalOverlay").style.display = "none";
}
function deleteQuiz(quizId) {
    let confirmDelete = confirm(
        "Are you sure to delete this quiz?"
    );
    if(confirmDelete == false){
        return;
    }
    let xhttp = new XMLHttpRequest();
    xhttp.open(
        "POST",
        "../Controller/DeleteQuiz.php",
        true
    );
    xhttp.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            if(this.responseText.includes("Deleted")){
                document.getElementById(
                    "quiz_row_" + quizId
                ).remove();
            }
            else{
                alert("Delete Failed");
            }
        }
    };
    xhttp.send(
        "quiz_id=" + quizId
    );
}