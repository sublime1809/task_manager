# Task Manager
This is my task manager. It is divided into two parts: API and interface. 
Both run their own servers. I have included a basic NodeJS server for the interface, but used Apache to run the API.

## API
The API is documented on [Apiary](http://docs.taskmanager2.apiary.io/#). It is a very basic RESTful API.
I used the following technologies:
* [Slim Framework](http://www.slimframework.com/) - I opted to learn a new-to-me framework because I was looking for something simple to create my API.
* [Doctrine](http://www.doctrine-project.org/) - This was an ORM that I used to model the tasks and it hooks into an SQLite DB.
* [Composer](https://getcomposer.org/) - Dependency management

## Interface
The interface is very simple. I would like to use bootstrap or material design to style it, but wrote basic custom styles for now.
Technologies:
* [Sass](http://sass-lang.com/) - This is my preprocessor of choice for the styles
* [Angular](https://angularjs.org/) - This is the meat of the frontend
* [Node](https://nodejs.org/en/) - I used Node to create a very basic webserver to display

## Communication
For the UI to interface with the API, I wrote an Angular Factory (taskFactroy in tasks directive) that is used by the taskController.
I wanted to separate out the API from the actual directive in order to allow flexibity to refactor the API.
