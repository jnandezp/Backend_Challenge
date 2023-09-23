<?php

namespace Crimsoncircle\Controller;

use Crimsoncircle\Model\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController
{

    /**
     *
     * Create new post
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request): string
    {
        $response = new JsonResponse(['error' => 'No record inserted'], Response::HTTP_OK);
        $title = $request->get('title');
        $content = $request->get('content');
        $author = $request->get('author');
        $slug = $request->get('slug');

        $post = new Post();
        // continue if validate = true
        $validate = $post->validateParams($title, $content, $author, $slug);
        if ($validate) {
            $existSlug = $post->search($slug);
            if (empty($existSlug)) {
                $post = $post->store($title, $content, $author, $slug);
                if ($post) {

                    $response = new JsonResponse($post);
                }
            } else {

                $response = new JsonResponse(['error' => 'Slug dupplicated'], Response::HTTP_OK);
            }
        }else{

            $response = new JsonResponse(['error' => 'Data invalid'], Response::HTTP_BAD_REQUEST);
        }

        return $response->getContent();
    }

    /**
     *
     * Search post by slug
     *
     * @param Request $request
     * @param string|null $slug
     * @return string
     */
    public function search(Request $request, string $slug = null): string
    {
        $response = new JsonResponse(['error' => 'No records find'], Response::HTTP_OK);

        $post = new Post();
        $posts = $post->search($slug);
        if (!empty($posts)) {
            $response = new JsonResponse($posts);
        }

        return $response->getContent();
    }

    /**
     *
     * Delete post by slug
     *
     * @param Request $request
     * @param string|null $slug
     * @return string
     */
    public function delete(Request $request, string $slug = null): string
    {
        $response = new JsonResponse(['error' => 'No record deleted'], Response::HTTP_OK);

        $post = new Post();
        $postFind = $post->search($slug);
        if (!empty($postFind)) {
            $post->delete($slug);

            $response = new JsonResponse([
                'message' => 'Entrada eliminada'
            ]);
        }

        return $response->getContent();
    }
}