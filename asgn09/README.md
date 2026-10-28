# WEB 250 - asgn09: Create a Record

This starter is based on the completed reference version of asgn08. It already contains the read-only Active Record methods and pages so everyone can begin asgn09 from roughly the same structure.

## Assignment goal

Add the **Create** portion of CRUD using:

- `public/bird_new.php`
- a `Bird::create()` instance method
- a PDO prepared `INSERT`
- named placeholders and `bindValue()`

## Database

Use the existing `wnc_birds` database and `birds` table from the previous assignments.

## Credentials

Copy:

```text
private/db_credentials.example.php
```

to:

```text
private/db_credentials.php
```

Then enter the database settings for your own local or hosted environment.

`private/db_credentials.php` is ignored by Git and must not be committed.

## Student README TODO

Before submitting asgn09, replace or expand this README with the information requested in the assignment instructions, including your create flow, prepared-statement explanation, MVC direction, Git branch workflow, and final URLs.

assignment name and purpose;
The purpose of this assignment is to plan and reuse our old code and create a new bird object. After creating the bird object, the page uses the header function to redirect the user to the new id page. The bird is successfully created and added to the database where the information will be present on the birds page with its unique id page. 

the database/table being used;
The database being used it the wnc-birds database. The tables used is the birds table, and it utilized all the rows and columns present in the table to display information.

that asgn09 adds the Create portion of CRUD;
This assignment adds the Create portion of CRUD.

that Bird.php acts as the model;
Bird.php acts as a model. What I did for this assignment is create the create() function which uses sql to create a new row inside of our birds table. It binds the values that are submitted via the form on the bird_new.php page and executes and then stores the id value into our lastInsertId() function in our database object. 

that birds.php is the directory view;
birds.php is directly a view because all it does is display information from our wnc-birds database.

that the application is moving toward MVC but is not a full MVC application yet;
It is almost a full MVC but our controller and modal parts of our app are one and they both are the same. I believe we need to separate them further. 

how the PDO prepared INSERT works at a high level;
PDO send SQL with places holder to the database, the database checks it, parses it, and plans how to run it. Then returns a statement handle. Then you supply values to exectue() or one at a time with bindValue(). the database runs the already-parsed statement with your values filled in with execute().
the dev-create branch workflow;
I first work on the dev-create branch while coding the additions to my code. Then once its all good for deployment, I add ., commit, to my dev-create branch and than I merge the dev-create branch and the main branch. Finally I push the changes to my main branch. 

how to run the application locally;
To run locally, put the files into my htdocs file in xampp folder and then I ensure I have proper credentials for the localhost phpmyadmin data base connection and then I navigate to the proper URL in my web broswer while also insuring that xampp is on with apache and mysql.

your GitHub URL and hosted URL after deployment.

GitHub URL: 
Hosting URL:
