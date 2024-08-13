
# PHP test

## 1. Installation

  - create an empty database named "phptest" on your MySQL server
  - import the dbdump.sql in the "phptest" database
  - put your MySQL server credentials in the src/Models config.ini
  - you can test the demo script in your shell: "php index.php"

## 2. Expectations

This simple application works, but with very old-style monolithic codebase, so do anything you want with it, to make it:

  - easier to work with
  - more maintainable

## 3. Solution:

  - I re-structure the folder namespaces for the developer be able to maintain it easily.
  - I eliminated some un necessary code to reduce the readability issues.
  - I formated response as an array similar to an Restful API response Format.
  - Added doc DocBlock in every method for the code to easily understand the parameter types and return types.

## 4. Recommendation

  - In the database schema, adding index to foreign key is very crucial to a RDBS especially when the data is being heavily loaded.
  - Use of namespace is much easier to track classes.
  - Using of transformer or response formatter is very helpful to easily modify any changes in the response format.
  - Using base classes like BaseModel is an example of DRY principly in coding or "Do not Repeat Yourself". It is specifically extended it in Models Classes.
  - Added basic testing for News create, create with comments, and delete. Just to emphasize importance of TDD.
