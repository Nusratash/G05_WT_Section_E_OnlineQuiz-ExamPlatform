function toggleUserStatus(userId, currentStatus) {
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let response = JSON.parse(this.responseText);
      if (response.success) {
        
        let row = document.querySelector(`tr[data-user-id="${userId}"]`);
        let statusSpan = row.querySelector('td:nth-child(5) span');
        let button = row.querySelector('td:nth-child(7) button');
        
        if (response.new_status == 1) {
          statusSpan.innerHTML = "Active";
          statusSpan.className = "active";
          button.innerHTML = "Suspend";
          button.className = "toggle-btn btn-active";
          button.setAttribute("onclick", `toggleUserStatus(${userId}, 0)`);
          
          
          let activeCount = document.getElementById("activeCount").innerHTML;
          let suspendedCount = document.getElementById("suspendedCount").innerHTML;
          document.getElementById("activeCount").innerHTML = parseInt(activeCount) + 1;
          document.getElementById("suspendedCount").innerHTML = parseInt(suspendedCount) - 1;
        } else {
          statusSpan.innerHTML = "Suspended";
          statusSpan.className = "inactive";
          button.innerHTML = "Activate";
          button.className = "toggle-btn btn-inactive";
          button.setAttribute("onclick", `toggleUserStatus(${userId}, 1)`);
          
          
          let activeCount = document.getElementById("activeCount").innerHTML;
          let suspendedCount = document.getElementById("suspendedCount").innerHTML;
          document.getElementById("activeCount").innerHTML = parseInt(activeCount) - 1;
          document.getElementById("suspendedCount").innerHTML = parseInt(suspendedCount) + 1;
        }
        
        document.getElementById("ajaxResponse").innerHTML = "Success! User status updated.";
        document.getElementById("ajaxResponse").style.color = "green";
      } else {
        document.getElementById("ajaxResponse").innerHTML = response.error;
        document.getElementById("ajaxResponse").style.color = "red";
      }
      
      setTimeout(function() {
        document.getElementById("ajaxResponse").innerHTML = "";
      }, 3000);
    } else if (this.readyState == 4) {
      document.getElementById("ajaxResponse").innerHTML = this.status;
      document.getElementById("ajaxResponse").style.color = "red";
    }
  };
  xhttp.open("POST", "../controller/api/ToggleUserController.php", true);
  xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  xhttp.send("user_id=" + userId + "&current_status=" + currentStatus);
}