let form=document.getElementById("quizForm");
let minute=parseInt(form.dataset.time);
let seconds=minute*60;

function tick()
{
    let m=Math.floor(seconds/60);
    let s=seconds%60;
    document.getElementById("timer").innerText=m+":"+s;
    seconds--;
    if(seconds<0)
    {
        document.getElementById("warning").innerHTML="⏰ Time's up!";
        submitQuiz();
    }
}
setInterval(tick,1000);

document.getElementById("submitBtn").onclick=submitQuiz;

function submitQuiz()
{
    let formData=new FormData(form);
    fetch("../../api/quiz/submit.php",{method:"POST",body:formData})
    .then(r=>r.text())
    .then(data=>{window.location=data;});
}