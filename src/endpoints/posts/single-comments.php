<?php
use LocalFeud\Helpers\NameGenerator;
use Respect\Validation\Validator;

$app->get('/posts/{id}/comments/', function($req, $res, $args) {


    /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
    $qb = $this->querybuilder;

    NameGenerator::setQB($qb);

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
        if( $comment->firstname == null && $comment->lastname == null) {
            list($firstname, $lastname) = NameGenerator::generate($args['id'], $comment->userid);
            $comment->firstname = $firstname;
            $comment->lastname = $lastname;

        }
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


        // Format date
        $d = new DateTime( $comment->date_posted );
        $comment->date_posted = $d->format('c');


    }




    $newRes = $res->withJson(
       $responseData, null, JSON_NUMERIC_CHECK
    );

    return $newRes;
})->setName('postComments');



    $app->post('/posts/{id}/comments/', function( \Slim\Http\Request $req, \Slim\Http\Response $res, $args) {

        /** @var \Pixie\QueryBuilder\QueryBuilderHandler $qb */
        $qb = $this->querybuilder;

        $comment = $req->getParsedBody();



        // Validate content
        if( !isset( $comment['content'] )) {
            throw new \LocalFeud\Exceptions\BadRequestException("Content not set");
        }

        if( !Validator::length(0,255)->validate($comment['content'])) {
            throw new \LocalFeud\Exceptions\BadRequestException("Content too long");
        }


        // TODO Use authenticated user instead
        $userID = 10;


        $comments = $qb->table('comments');
        $comments->insert(
            [
                'content' => $comment['content'],
                'authorid' => $userID,
                'postid' => $args['id']
            ]
        );

        $newRes = $res->withJson(
            [
                'status' => 200
            ], null, JSON_NUMERIC_CHECK
        );

        return $newRes;

    });