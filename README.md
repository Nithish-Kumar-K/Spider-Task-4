-# Spider-Task-4
-This is the repo for the fourth spider task - Authentication and Authorization.
+# Spider Task 2-Student Database (Backend)  
+-----------------------------------------
+
+This project is for making a student database that stores the details of the students. This project was created
+using the following tools.
+Programming Language : PHP
+Database : MySQL
+Server : Apache2
+
+Apart from these tools you would also need a text editor like Atom.
+
+## Installation
+------------
+
+Below are the links for downloading all the necessary software required to run the scripts :
+
+### For Windows   
+
+
+  1. Install Apache. [Click here](https://www.sitepoint.com/how-to-install-apache-on-windows/) to install Apache. This page provides a proper explanation for the installation.
+  2. Install php5. [Click here](https://www.sitepoint.com/how-to-install-php-on-windows/) to get a step by step method on how to install and configure php5 on your system.
+  3. Install MySQL. [Click here](https://www.sitepoint.com/how-to-install-mysql/) to get a step by step method for doing this.
+
+### For Linux
+
+[This link](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-14-04) provides a clean step by step process for installation of LAMP.
+Altenatively, LAMP can also be installed by giving the following commands in the termianl.
+  1. sudo apt-get update
+  2.  sudo apt-get install tasksel
+  3. sudo tasksel install lamp-server
+
+It is recommended to follow the step by step process as it provides a better understanding.
+
+The details about the database and the tables used are given below :
+
+  1. The user is 'Nithish'@'localhost' (all privileges have been granted).
+  2. Password is 'Hohaahoh'.
+  3. The database name is 'bulletin_board'.
+  4. The tables used are 'users' and 'board'.
+
+The CREATE TABLE command for the users (which is a table containing all users) is given below.
+```
+CREATE TABLE users(
+USERNAME varchar(100) not null unique primary key,
+EMAIL varchar(100) not null,
+ABOUT_ME varchar(1000),
+PASSWORD varchar(100) not null,
+ACCESS varchar(100) not null
+);
+```
+The CREATE TABLE command for board (which is a table for all bulletin messages) is given below.
+```
+CREATE TABLE board(
+BULLETIN varchar(1000) not null,
+ID int not null primary key AUTO_INCREMENT
+);
+```
+For creating a new admin, the following command should be used.
+```
+INSERT INTO users (USERNAME,EMAIL,ABOUT_ME,PASSWORD,ACCESS)
+VALUES('username','mail@gmail.com','nothing','PASSWORD','admin');
+```
+
+Either you can create a user and database as mentioned above or you can use your own user and database. If however,
+you choose to create  a new database appropriate changes should be made to the php files.
+
+The mysqli library has been used for connecting to the database.
+
+## For running the scripts ##
+------------------------
+
+  1. Clone this repository.
+  2. Start your apache server.
+  3. Copy all the files from Task_2 in Repository Spider Inductions to your localhost directory.
+(Windows- C:/inetpub/wwwroot) (Linux- /var/www/html ).
+  4. Open up your browser. Type http://localhost/ as the URL.
+  5. Click on studentdatabase.php to use the student database.
