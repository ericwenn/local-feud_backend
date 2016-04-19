<?php
	$app->get('/posts/{id}/comments/', function( $req, $res, $args) {


        /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
        $qb = $this->querybuilder;

        /** @var \Slim\Router $router */
        $router = $this->get('router');


        $comments = $qb->table('comments');

        $comments->where('comments.postid', '=', $args['id']);

        $comments->leftJoin('post_commentators', function( $table ) {
            $table->on('comments.postid', '=', 'post_commentators.postid');
            $table->on('comments.authorid', '=', 'post_commentators.userid');
        });

        $comments->leftJoin('posts', 'comments.postid', '=', 'posts.id');



        $comments->select(
            [
                'comments.id',
                'comments.date_posted',
                $qb->raw('comments.authorid as userid'),
                'posts.authorid',
                'post_commentators.firstname',
                'post_commentators.lastname',
                'comments.content'
            ]
        );


        $responseData = $comments->get();

        foreach( $responseData as &$comment) {

            // format is_original_poster
            $comment->is_original_poster = $comment->userid == $comment->authorid;


            // format user
            $user = [
                'id' => $comment->userid,
                'firstname' => $comment->firstname,
                'lastname' => $comment->lastname,
                'href' => $router->pathFor('user', [ 'id' => $comment->userid ])
            ];
            $comment->user = $user;


            unset($comment->authorid);
            unset($comment->userid);
            unset($comment->firstname);
            unset($comment->lastname);







        }




        /*
        $date = new DateTime('now');

        $dummyResponse = array(
            array(
                'id' => 1,
                'user' => array(
                    'id' => 1,
                    'firstname' => 'Karl',
                    'lastname' => 'Karlsson',
                    'href' => API_ROOT_URL . '/users/1/'
                ),
                'content' => 'Lorem ipsum dolorem-comment.',
                'date_posted' => $date->format('c'),
                'is_original_poster' => false,
                'href' => API_ROOT_URL . '/posts/1/'
            ),
            array(
                'id' => 2,
                'user' => array(
                    'id' => 1,
                    'firstname' => 'Karl',
                    'lastname' => 'Karlsson',
                    'href' => API_ROOT_URL . '/users/1/'
                ),
                'content' => 'Lorem ipsum dolorem-comment.',
                'date_posted' => $date->format('c'),
                'is_original_poster' => false,
                'href' => API_ROOT_URL . '/posts/1/'
            )
        );
        */

        $newRes = $res->withJson(
           $responseData, null, JSON_NUMERIC_CHECK
        );

        return $newRes;
    })->setName('postComments');