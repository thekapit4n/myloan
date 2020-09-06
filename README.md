# myloan System
This is simple system will calculate amount to be paid by weekly basis based on the amount of loan and the loan terms. The user will submit their amount of loan and terms of loan, then the management will review the loan. After reviewing, the management site can decide either to approve or  disapprove the loan.User only need to pay the loan that has been approved by the management by simply click the button pay.

## This System Develop Using :
- php version 7 with framework CodeIgniter 3
- MySQL Database
- JQuery, Bootstrap 4,CSS and HTML.

## Type of Web Service
- SOAP(Simple Object Access Protocol) web services.

## Before Run The Project
- Download the project and locate into **htdocs (xampp)** or **www** folder.
- Create MySQL database name ***myloan*** and import the sql file name ***myloan.sql*** that has been included in this project.
- Find ***extension=php_soap.dll*** or ***extension=soap*** in ***php.ini*** and remove the commenting semicolon at the beginning of the line.Then restart your server.
  - For more details can refer to this link : 
   [https://stackoverflow.com/questions/2509143/how-do-i-install-soap-extension]
   
## myloan Folder Structure
- **application folder** is main directory in CodeIgniter framework. It contain all the files to run the system.
  - **config folder** The Config directory contains all configuration of your application. For example : 
      - **config.php** contain the configuration of Base URL, Index file, URI   Protocol etc. 
      - **autoload.php** contain the configuration to set packages, libraries, drivers, helper files, custom config files, language files and models should be loaded by default. 
      - **database.php** contains the configuration of the database like database driver, database name, username, password etc.
      - **route.php** contain configuration of routing the default controller when run the project.
  - **controllers folder** contain all controllers file of the system. 
  - **views folder** contain all views file of the system.
  - **models folder** contain all models file of the system.
  - **helpers folder** contain all helper function and class that not been included in CodeIgniter.For this project, general_helper.php is custom helper that been created to    ease the project development.
  - **assets folder** is directory that contain all CSS file and Javascript file for UX/UI of the system.
- For more information can refer to this website [https://www.w3adda.com/codeigniter-tutorial/codeigniter-directory-structure]



## Type of user for testing
- **User :** 
  - There are predefine user that can be use for login and test : 
    - Username : tester1
    - Password : T3$ter123
  - New user also can be create by fill up the register form. The form can be found by click the link *Register New Account* on login page. 
- **Admin/Management**
  - There are admin info for login and test:
    - Username : admin
    - Password : @Dmin123
