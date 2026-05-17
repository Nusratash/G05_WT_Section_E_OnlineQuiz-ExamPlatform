let form = document.getElementById("quizForm");
let minute = parseInt(form.dataset.time);
let seconds = minute * 60;
let timerInterval;
let isSubmitted = false;

function tick() {
    let m = Math.floor(seconds / 60);
    let s = seconds % 60;
    document.getElementById("timer").innerText = m + ":" + (s < 10 ? "0" + s : s);
    seconds--;
    
    if (seconds < 0 && !isSubmitted) {
        document.getElementById("warning").innerHTML = "⏰ Time's up! Auto-submitting...";
        clearInterval(timerInterval);
        submitQuiz();
    }
}

timerInterval = setInterval(tick, 1000);

document.getElementById("submitBtn").onclick = function(e) {
    e.preventDefault();
    if (!isSubmitted) {
        submitQuiz();
    }
};

function submitQuiz() {
    if (isSubmitted) return;
    isSubmitted = true;
    
    let formData = new FormData(form);
    fetch("../../api/quiz/submit.php", { 
        method: "POST", 
        body: formData 
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else if (data.error) {
            alert(data.error);
            window.location.href = "../view/quiz_list.php";
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Submission failed. Please try again.");
        isSubmitted = false;
    });
}