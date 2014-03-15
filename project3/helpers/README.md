##Header

This should be added to the top of every page. Include it like: `include("helpers/header.php")`.

###What it does

+ Starts the session - important to keep the user logged in.
+ Turns on error reporting (for now).
+ If a user is logged in it sets `$userId` to their id
+ Includes and creates a new database instance
+ Adds the base html elements up to the opening `body` tag

###Important variables

+ Before including the header - if you set `$pageTitle` to be the text that you want the page's title to be the header will set the `title` tag correctly.
+ After including the header you have access to useful variables.
  + `$userId`: holds the id of the currently logged in user
  + `$db`: is an instance of the Database class - use this class to make all the MySQL queries

##Footer

This should be added to bottom of every page. Include it like: `include("helpers/header.php")`. Currently it just closes the `html` and `body` tags, but could do more in the future.

##Database Class

Heroku does not support the `mysqli` extension so we are going to have to use the `mysql` extension. I decided that instead of cluttering our code with annoying `mysql_whatever` calls that I would just encapsulate it in a nice Database class. The class is included in the header file and an instance is created using the variable `$db`. The class handles all the connecting and other intricacies of the `mysql` extension.

###Important Attributes and Methods

+ `makeQuery($query, [$queryParameters])` - call this to execute a query on the database. The first argument is a query with `?` in the place of the variable items. The second argument and beyond are optional. These are the items to put in place of the question marks in the query. They should be in the order that they are in the query.
+ `result` - call this variable after executing a query if rows are returned. It holds the result of the query as a two-dimensional array. The rows returned are the inner arrays.
+ `numRows` - call this variable after executing a query if you want to find out how many rows the query returned.

###Errors

If an error occurs when connecting to or making a query an `Exception` is thrown.

###Example Usage

```php
$query = "SELECT Id, Name FROM Users WHERE email = ? AND DeptId = ?";

try {
  $db->makeQuery($query, "jd@431.edu", "CS");
}
catch (Exception $e) {
  die("Database connection invalid.");
}

if ($db->numRows > 0) {
  foreach($db->result as $row) {
    echo $row['Id'];
    echo $row['Name'];
  }
}
else {
  die("No user found");
}
```