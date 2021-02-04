# php-mysql-social-network
A simple social network created using PHP and MySQL.

Project done as a part of CSE-5335 Web Data Management Course at UTA.

Problem statement is as follows,

<p align="justify">
Create 10 users in the table users using phpMyAdmin. You need to write two PHP scrips login.php and network.php. The login.php script generates a form that has two text windows for username and password and a button "Login". The network.php script prints three sections and a "Logout" button. The first section prints the username, fullname, and email of the current user (the user currently logged-in). The second section "Friends" lists the friends of the current user. The third section "Others" lists all the other users who are not friends (non-friends) of the current user. For each friend or non-friend you display username, fullname, and email. Each friend has a button "Remove" to remove her from the friends and add her to the non-friends. Each non-friend has a button "Add" to add her to the friends and remove her from the non-friends. 
</p>

<p align="justify">
From the login script, if the user enters a wrong username/password and pushes "Login", it should go to the login script again. If the user enters a correct username/password and pushes "Login", it should go to the network script. From the network script, if the user pushes "Logout", it should logout and go to the login script. The network script must always make sure that only authorized users (users who have logged-in properly) can use this script (you need to use a session to check this). 
</p>

<p align="justify">
Hints: Each Add/Remove button must have an action that submits the form to network.php with a different query string. You may use a form button with type="submit" and formaction="network.php?add=smith" to add smith as a friend and formaction="network.php?remove=smith" to remove smith from friends. Use md5 to encode passwords in PHP. 
</p>

<img src="https://github.com/c-deshpande/php-mysql-social-network/blob/main/img/login.PNG" alt="login">

<img src="https://github.com/c-deshpande/php-mysql-social-network/blob/main/img/home.PNG" alt="home">

<img src="https://github.com/c-deshpande/php-mysql-social-network/blob/main/img/home-1.PNG" alt="home_1">
