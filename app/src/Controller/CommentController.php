<?php

namespace Crimsoncircle\Controller;

use Crimsoncircle\Model\Comment;
use Crimsoncircle\Model\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController
{

    /**
     *
     * get 10 comments in post
     *
     * @param Request $request
     * @param $id
     * @return false|string
     */
    public function commentsInPost(Request $request, $id = null){
        $response = new JsonResponse(['error' => 'No records find'], Response::HTTP_OK);
        $page = $request->query->get('page', 1);

        $post = new Post();
        // post id is valid
        $postResult = $post->getById($id);
        if (!empty($postResult)) {

            $comment = new Comment();
            $commentResult = $comment->getByPostId($id, $page);
            if (!empty($commentResult)) {

                // paginate


                $response = new JsonResponse($commentResult);
            }
        }

        return $response->getContent();
    }

    /**
     *
     * create new comment
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request): string
    {
        $response = new JsonResponse(['error' => 'No record inserted'], Response::HTTP_OK);
        $postId = $request->get('post_id');
        $content = $request->get('content');
        $author = $request->get('author');

        $comment = new Comment();
        // continue if validate = true
        $validate = $comment->validateParams($postId, $content, $author);
        if ($validate) {
            $commentResponse = $comment->store($postId, $content, $author);
            if ($commentResponse) {
                $response = new JsonResponse($commentResponse);
            }

        } else {
            $response = new JsonResponse(['error' => 'Data invalid'], Response::HTTP_BAD_REQUEST);
        }

        return $response->getContent();
    }

    /**
     *
     * Search comment by id
     *
     * @param Request $request
     * @param int|null $id
     * @return string
     */
    public function searchById(Request $request, int $id = null): string
    {
        $response = new JsonResponse(['error' => 'No records find'], Response::HTTP_OK);
        $blog = new Comment();

        $comment = $blog->getById($id);
        if (!empty($comment)) {
            $response = new JsonResponse($comment);
        }

        return $response->getContent();
    }

    /**
     *
     * Delete comment by id
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public function delete(Request $request, int $id): string
    {
        $response = new JsonResponse(['error' => 'No record deleted'], Response::HTTP_OK);

        $comment = new Comment();
        $commentResult = $comment->getById($id);
        if (!empty($commentResult)) {
            $post = $comment->delete($id);

            $response = new JsonResponse([
                'message' => 'Entrada eliminada'
            ]);
        }

        return $response->getContent();
    }
}