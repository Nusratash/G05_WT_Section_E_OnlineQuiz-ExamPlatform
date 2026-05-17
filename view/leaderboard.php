<!DOCTYPE html>
<html>
    <head>
        <title>Leaderboard</title>
    <link rel="stylesheet" href="css/leaderboard_stylesheet.css">
    </head>
    <body>
        <table id="leaderboardTable">
            <tr><th colspan="3"><h1>Leaderoard</h1></th></tr>
            <tr>
                <td></td>
                <td></td>
                <td><span id="countdown">Refresh: 30s</span></td>
            </tr>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Total Score</th>
            </tr>
            <tr><td colspan="3" style="text-align:center"><button><a href="#">Close</a></button></td></tr>
        </table>
        <script>
        let timeLeft=30;
        function updateCountdown()
        {
            document.getElementById("countdown").innerText="Refresh: "+timeLeft+"s";
            timeLeft--;

            if(timeLeft<0)
                {
                    timeLeft=30;
                }
        }


        function loadLeaderboard()
        {
            fetch("../api/leaderboard.php")
            .then(response=>response.json())
            .then(
            data=>
            {
                let html=`
                    <tr><th colspan="3"><h1>Leaderoard</h1></th></tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><span id="countdown">Refresh: 30s</span></td>
                    </tr>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Total Score</th>
                    </tr>
                `;

                for(let i=0;i<data.length;i++)
                {
                    html+=`
                        <tr>
                            <td>${i+1}</td>
                            <td>${data[i].name}</td>
                            <td>${data[i].total_score}</td>
                        </tr>
                    `;
                }

                html+=`<tr><td colspan="3" style="text-align: center"><button><a href="#">Close</a></button></td></tr>`;

                document.getElementById("leaderboardTable").innerHTML=html;
                timeLeft=30;
            });
        }

        loadLeaderboard();
        setInterval(loadLeaderboard,30000);
        setInterval(updateCountdown,1000);
        </script>
    </body>
</html>