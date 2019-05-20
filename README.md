# Online Virus Checking 

## What is it?
The idea is to create a web-based Antivirus application that allows the users to upload a file (of any type) to check if it contains malicious content. That is, if it is a Malware or not. 

## Team
Nhat Trinh <br/>
Phillip Rognerud <br/>
Truc Vo <br/>

## Features
These are some of the features we implemented in this project:
- [x] Infected File: It is a File that contains a Virus.
- [x] Putative Infected File: It is a File that might contain the Virus and needs to go under analysis.
- [x] Allows the user to submit a putative infected file and shows if it is infected or not.
- [x] The website will let register a user to the website as a Contributor, asking for username, email and password.
- [x] Stores the information related to the Admin with username and password, in the most secure way of your knowledge.
- [x] When a registered user, that is, a Contributor, logs in on the website, s/he can upload a Malware file and the relative signature is stored in a different table that the one containing the actual Malware information, containing putative malware that must be double checked by an Admi

## Installing
1. Clone the Repo
```javascript
git clone
```
2. Put the workspace into XAMPP/htdocs
3. Start all the server, which include MySQL, Apache, ProFTPD
<img src= "https://github.com/NhatTrinh/Virus-Checker/blob/master/img/server.png" width="400px"/>
4. Define port for the host machine
<img src= "https://github.com/NhatTrinh/Virus-Checker/blob/master/img/port.png" width="400px"/>
5. Mount the project to start 
<img src= "https://github.com/NhatTrinh/Virus-Checker/blob/master/img/mount.png" width="400px"/>
6. Go to http://localhost:8080/phpmyadmin/server_databases.php?server=1 <br/>
- Create a database, i.e cs174 <br/>
- Import the sql file into the database <br/>
    <img src= "https://github.com/NhatTrinh/Virus-Checker/blob/master/img/import.png" width="600px"/>
7. Go to your localhost <br/> http://localhost:8080/Virus-Checker/index.php
8. Login as admin with username "admin@sjsu.edu" and password "password"
## Screenshots

