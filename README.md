# PHP Best Practices exercise
*This document and project aren't finished*
## Goal
This exercise is aimed at students who master basic PHP and OOP progranning.
It helps to improve progranning skills and use industry standard tools.

We'll develop a very simple PHP script that reads user input and writes it to
a database table.
The emphasis is on best practices to help create code that is:
* easy to maintain
* robust
* secure
## The exercise
Write a PHP script that shows a form asking a first name, last name, birth
year and comment. The first three values are required, the comment is optional.
Every first name and last name combination must be unique. A submit button
writes the data to a database table when clicked. After writing the data the
user is informed about the success or failure of the write operation and a new
form allows to enter new data.
The small app can be written individually. When ready form small groups and
review each other's code. Determine how easy it is to follow someone else's
application logic. What is good, what can be improved?
Test the code using a unit testing platform. Try to develop meaninful tests.
Together, evaluate the advantages and weaknesses of the best practices used in
the exercise.
## Best practices
These should be seen as *non-obligatory recommendations* that help us produce
high-quality code.
Being *consistent and methodological* is more important than the chosen methods.
The methods presented in this exercise are widely adopted and understanding
them opens the way to seeing the benefits of applying recommendations and
coding standards, regardless of the ones we choose.
Frameworks do a lot of work for us and for this exercise we ask to use *native
PHP* in order to understand the best practices and how to apply them in our own
code.
### The database
Database engines are optimised to efficiently handle large amounts of data.  We
should use this knowledge to our advantage by implementing as much business
logic as possible in the database. Reducing the number of database requests
improves performance and can help to avoid some of the problems inherent to
the concurrent environment of web-applications.
#### Example
Checking the existence of a value in a first query and inserting that value in a
second query doesn't guarantee uniqueness because another user could be sending
the same value at the same time. Using a unique index in the table will require
only one query and reliably avoids duplicates. Checking the status after query
execution allows to send feedback to the user.
### Application structure
Structuring an application in a logical way makes it more easy to maintain and
more reliable. Starting with the architecture of an application makes it easier
to follow a top-down approach and develop more efficiently.
Modularising the application allows for code reuse, simultaneous development and
teamwork.
#### Example
In the MVC architecture we separate presentation, data and the interactions
between them in separate modules.
#### Techniques
Object Oriented Programming is a technique for modularising our applications.
Encapsulation and abstraction ease the maintenance and evolution of applications
over time.
### The codebase
We have seen how modularisation helps to keep an overview on our codebase.
The way we write our code helps to make it more easy to read.
Namespaces are a tool to separate our class and function names from those from
third party modules while keeping them together over our own modules.
#### Coding style
Language structures become more clear when using proper indentation. Naming
conventions for classes, variables and constants help us interpret the
different elements in our code more easily.
In PHP the [PSR-2 Coding Style Guide](https://www.php-fig.org/psr/psr-2/) is
the standard for coding style. Applying this standard is a sign of
professionalism. Tools like
[php-cs-fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) assist us to keep
our code conform.
#### Documentation
Insert pertinent comments into your code. Learn about
[phpDocumentor](https://www.phpdoc.org/) and debate how and when it can be
helpful. Find alternatives.
### Security
#### User input
SQL Injection threatens every database-driven web-site or application.
Check and sanitize all inputs and avoid constructing SQL queries by
concatenating strings with user input. Use secure alternatives for parameterized
database queries.
### Debugging
#### Error handling
Anticipate possible errors. Read the documentation for every function you use
and pay special attention to return values and error reporting or exceptions.
Use proper error reporting and handling for your own functions and methods.
Use assert calls to check status at crucial points in the application.
#### Xdebug
Setup [Xdebug](https://xdebug.org/) on your server and your IDE or code editor.
Start a debug session and explore the possibilities of Xdebug.
### Unit testing
Setup [PHPUnit](https://phpunit.de/) on your computer and learn about it.
Evaluate which functions and methods need testing. Develop tests that cover all
identified problem sources. Execute the tests and draw conclusions. Correct the
code where needed and run the tests again.
