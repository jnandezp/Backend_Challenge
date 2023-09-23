# Backend_Challenge

## Challenge 1: Setup the project
Start the services for the project (this action will re-build the containers)

`docker-compose up -d --build`

Stop the services for the project

`docker-compose down`

## LOGS

To wiew the logs of all services for the project:

`docker-compose logs -f`

To view the logs from nginx:

`docker-compose logs -f web`

To view the logs from php-fpm:

`docker-compose logs -f php-fpm`

To view the logs from Mysql:

`docker-compose logs -f db`

Install dependencies for the project

`docker-compose exec php-fpm bash -c "composer install"`

To regenerate the information for the autoloader file:

`docker-compose exec php-fpm bash -c "composer dump-autoload"`


## Database

You can manage the databases from mysql using the next url:

`http://localhost:8000`

Information for the database connection from PHP scripts:

```
Username: root
Password: crimsoncircle
Host: db
```

## Challenge 2: Leap Year Module

The URL for access to the module:

`http://localhost:8080/is_leap_year/{year}`

Implement the logic to calculate if the year is a "Leap Year", and fix the bug when a year is not set on the URL, in that case by default the year is the actual year, here is two examples about how get the information:

`http://localhost:8080/is_leap_year/2020`

`http://localhost:8080/is_leap_year`


## Challenge 3: Blog Site API

*Create the database for store the information.* 

Write a class that allows manage the connection with the database. Also write the controllers and Models that allow create a REST API with the next endpoints:

**Create a new BlogPost**

```
POST http://localhost:8080/blog
{
    "title": 'The title of new blog post',
    "content": 'This is the content for a new blog post',
    "author": "The name of the author for the new blog post",
    "slug": "/the_title_of_new_blog_post"
}
```

**Get the information of a blog spot (search it by slug)**

```
GET http://localhost:8080/blog/the_title_of_new_blog_post
{
    "id": 123456
    "title": 'The title of new blog post',
    "content": 'This is the content for a new blog post',
    "author": "The name of the author for the new blog post",
    "slug": "/the_title_of_new_blog_post",
    "created_at": "2023-01-30 19:00:00"
}
```

**Delete a blog spot using the slug**

`DELETE http://localhost:8080/blog/the_title_of_new_blog_post`


**Create a new comment for a specific blog post**

```
POST http://localhost:8080/comment

{
    "post_id": 123456,
    "content": "This is a comment for the post wit id 123456",
    "author": "Miguel Gutierrez"
}
```

**Get the information for a comment (search it by id)**

```
GET http://localhost:8080/commet/12345

{
    "id": 12345
    "post_id": 123456,
    "content": "This is a comment for the post wit id 123456",
    "author": "Miguel Gutierrez",
    "created_at": "2023-01-30 19:00:00"
}
```

**Delete a comment by the Id**

`DELETE http://localhost:8080/commet/12345`


**Get the list of comments for the specific post id, the list must be displayed by pages, and each page display only 10 comments at the time**

```
GET http://localhost:8080/comment/post/123456?page=1

[
  {
      "id": 12345
      "post_id": 123456,
      "content": "This is a comment for the post wit id 123456",
      "author": "Miguel Gutierrez",
      "created_at": "2023-01-30 19:00:00"
  },
  {
      "id": 12346
      "post_id": 123456,
      "content": "This is the second comment for the post wit id 123456",
      "author": "Juan Perez",
      "created_at": "2023-01-30 19:15:00"
  }
]
```

**NOTE:** you can retrieve the page parameter using the following way:

`$request->query->get('page'), which $request variable is an instance of Symfony\Component\HttpFoundation\Request class`
