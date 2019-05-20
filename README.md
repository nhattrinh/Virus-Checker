# Online Virus Checking 

## What is it?
The idea is to create a web-based Antivirus application that allows the users to upload a file (of any type) to check if it contains malicious content. That is, if it is a Malware or not. 

## Team
Nhat Trinh <br/>
Phillip Rognerud <br/>
Truc Vo <br/>

## Features
These are some of the features we implemented in this project:
- [x] User Authenticatio
- [x] Password Management
- [x] File uploading
- [x] Sessions and Cookies
- [x] Client-side Validation
- [x] Admin level integration

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
7. Go to your localhost <br/> 
http://localhost:8080/Virus-Checker/index.php <br/>
8. Login as admin with username "admin@sjsu.edu" and password "password"


## Screenshots
<img src= "https://github.com/NhatTrinh/Virus-Checker/blob/master/img/home.png" width="600px"/>
<img src= "https://github.com/NhatTrinh/Virus-Checker/blob/master/img/checkfile.png" width="600px"/>
