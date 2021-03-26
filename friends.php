<?php // User profile
// Set page title
$cfg_title = "Friend List - MemoryMaze";
// Load standard header from file
include 'header.php'; ?>

<!-- Content goes here -->
<h1>Friend List</h1>

<div class="searchbox">
    Search for a friend: <br/>
    <input class="friend-searchbox" id="friendsearch" onkeyup="friendSearch(this.value)" placeholder="Enter a username" />
    
    <div id="friend-suggestions"></div>
</div>

<div class="mini-profile">
    <span class="mini-profile-name">Auntie</span>
    <img src="./assets/avocado.png" class="mini-profile-img" /><br/>
    <span class="mini-profile-high-score">High Score: 94</span><br/>
    <span class="mini-profile-last-login">Last Login: 10/3/2021</span>
</div> &nbsp;
<div class="mini-profile">
    <span class="mini-profile-name">Uncle</span>
    <img src="./assets/banana.png" class="mini-profile-img" /><br/>
    <span class="mini-profile-high-score">High Score: 95</span><br/>
    <span class="mini-profile-last-login">Last Login: 13/3/2021</span>
</div>

<script>
function friendSearch(v) {
    if (v.length == 0) {
        document.getElementById("friend-suggestions").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("friend-suggestions").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "friend_search.php?q=" + v, true);
        xmlhttp.send();
    }   
}
</script>

<?php // Load footer
include 'footer.php'; ?>