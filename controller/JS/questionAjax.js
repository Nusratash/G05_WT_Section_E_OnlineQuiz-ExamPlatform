function openModal() {

    document.getElementById(
        "modalOverlay"
    ).style.display = "flex";
}

function closeModal() {
    document.getElementById(
        "modalOverlay"
    ).style.display = "none";
}

function deleteQuiz(quizId) {
    let confirmDelete = confirm(
        "Are you sure to delete this quiz?"
    );

    if(confirmDelete == false){
        return;
    }

    let xhttp = new XMLHttpRequest();

    xhttp.open( "POST", "../Controller/DeleteQuiz.php",true);

    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded" );

    xhttp.onreadystatechange = function () {

        if(this.readyState == 4){

            if(this.status == 200){

                if(
                    this.responseText.trim() == "Deleted"
                ){

                    document.getElementById(
                        "quiz_row_" + quizId
                    ).remove();
                }
                else{

                    alert("Delete Failed");
                }
            }
        }
    };

    xhttp.send(
        "quiz_id=" + quizId
    );
}

function toggleQuizStatus(quizId) {

    let xhttp = new XMLHttpRequest();

    xhttp.open("POST","../Controller/ToggleQuizStatus.php",true
    );

    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded"
    );

    xhttp.onreadystatechange = function () {
        if(this.readyState == 4){
            if(this.status == 200){
                try{
                    let response = JSON.parse(
                        this.responseText
                    );
                    if(response.success == true){
                        if(response.status == "published"){
                            document.getElementById(
                                "status_" + quizId
                            ).innerHTML = "Published";
                            document.getElementById(
                                "toggle_btn_" + quizId
                            ).innerHTML = "Unpublish";
                        }
                        else{
                            document.getElementById(
                                "status_" + quizId
                            ).innerHTML = "Draft";

                            document.getElementById(
                                "toggle_btn_" + quizId
                            ).innerHTML = "Publish";
                        }
                    }
                    else{
                        alert(
                            "Cannot publish quiz without questions"
                        );
                    }
                }
                catch(error){

                    console.log(error);

                    alert(
                        "Status Toggle Failed"
                    );
                }
            }
        }
    };

    xhttp.send("quiz_id=" + quizId
    );
}