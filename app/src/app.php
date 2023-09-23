<?php
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => 'Crimsoncircle\Controller\LeapYearController::index',
]));

// POST new post
$routes->add('blog_post_create', new Routing\Route('/blog', [
    'methods' => ['POST'],
    '_controller' => 'Crimsoncircle\Controller\BlogController::store',
]));

// DELETE delete a post
$routes->add('blog_post_delete', new Routing\Route('/blog/{slug}', [
    'slug' => null,
    'methods' => ['DELETE'],
    '_controller' => 'Crimsoncircle\Controller\BlogController::delete',
], array(), array(), '', array(), array('DELETE')));

// GET search post
$routes->add('blog_post_search', new Routing\Route('/blog/{slug}', [
    'slug' => null,
    'methods' => ['GET'],
    '_controller' => 'Crimsoncircle\Controller\BlogController::search',
]));




// POST new comment
$routes->add('blog_comment_create', new Routing\Route('/comment', [
    'methods' => ['POST'],
    '_controller' => 'Crimsoncircle\Controller\CommentController::store',
]));

// DELETE delete a comment
$routes->add('blog_comment_delete', new Routing\Route('/comment/delete/{id}', [
    'id' => null,
    'methods' => ['DELETE'],
    '_controller' => 'Crimsoncircle\Controller\CommentController::delete',
    'requirements'=> [
        '_method' => 'DELETE'
    ]
], array(), array(), '', array(), array('DELETE')));

// GET search comment
$routes->add('blog_comment_search_by_id', new Routing\Route('/comment/{id}', [
    'id' => null,
    'methods' => ['GET'],
    '_controller' => 'Crimsoncircle\Controller\CommentController::searchById',
]));




// GET 10 comments per page for a post_id
$routes->add('blog_comments_in_post', new Routing\Route('/comment/post/{id}', [
    'id' => null,
    'methods' => ['GET'],
    '_controller' => 'Crimsoncircle\Controller\CommentController::commentsInPost',
]));


return $routes;

