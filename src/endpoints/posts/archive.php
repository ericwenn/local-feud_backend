<?php
    namespace LocalFeud;
/**
 * @api {get} /posts/ List of Posts
 * @apiName GetPosts
 * @apiGroup Post
 *
 *
 * @apiParam {Number{-90 - 90}} latitude                         The latitude of centerpoint which the posts will be around
 * @apiParam {Number{0 - 180}} longitude                         The longitude of centerpoint which the posts will be around
 *
 *
 * @apiParamExample {json} Request-Example
 *      {
 *          "latitude": 52.123123,
 *          "longitude": 11.123123,
 *      }
 *
 * @apiSuccess {Object[]}	posts 					    The Posts
 * @apiSuccess {Number} 	posts.id 				    ID of the Post
 * @apiSuccess {Number}	    posts.reach				    Reach of the Post, measured in kilometers
 * @apiSuccess {Date}		posts.date_posted		    Date when the Post was created
 * @apiSuccess {Number}	    posts.number_of_comments    Number of Comments on the Post
 * @apiSuccess {Number}	    posts.number_of_likes       Number of Likes on the Post
 * @apiSuccess {Boolean}    posts.current_user_has_liked
 *
 * @apiSuccess {Object[]}	posts.user 			        The User who created the Post
 * @apiSuccess {Number}		posts.user.id 		        ID of the User
 * @apiSuccess {URL}		posts.user.href 		    Reference to the endpoint
 *
 * @apiSuccess {Object[]}	posts.content				The content of the Post
 * @apiSuccess {String}		posts.content.type          The type of content the Post has
 * @apiSuccess {String}		posts.content.text 	        The text of the Post. Only returned if content.type == 'text'
 * @apiSuccess {String}		posts.content.image_src 	URL of Posts image. Only returned if content.type == 'image'
 *
 * @apiSuccess {Object[]}	posts.location		        Information of the location of the Post.
 * @apiSuccess {Number}		posts.location.distance     Number between 0 and 10 denoting the distance from the post
 *
 * @apiSuccess {String}		posts.href				    Reference to the endpoint
 *
 *
 *
 * @apiUse Unauthorized
 */

	use DateTime;
    use LocalFeud\Exceptions\BadRequestException;
    use LocalFeud\Helpers\User;
    use Pixie\Exception;
    use Pixie\QueryBuilder\JoinBuilder;
    use Pixie\QueryBuilder\QueryBuilderHandler;
    use Respect\Validation\Validator;
    use Slim\App;
    use Slim\Http\Request;
    use Slim\Http\Response;

    /** @var App $app */
    $app->get('/posts/', function($req, Response $res, $args ) {

        /** @var \Pixie\QueryBuilder\QueryBuilderHandler $queryBuilder */
        $queryBuilder = $this->querybuilder;

        // TODO Get-parameters not added yet. These points *should* be in Gothenburg.
        $fake_latitude = 52.23123;
        $fake_longitude = 11.123123;

        $userID = User::getInstance()->getUserId();


        $requestLocation = new Helpers\Location($fake_latitude, $fake_longitude);


        $posts = $queryBuilder->table('posts');

        $posts->leftJoin('likes', 'posts.id', '=', 'likes.postid');
        $posts->leftJoin('comments', 'posts.id', '=', 'comments.postid');


        $posts->leftJoin( $queryBuilder->raw('likes as l'), function( JoinBuilder $table ) use ($userID, $queryBuilder) {
            $table->on('posts.id', '=', 'l.postid');
            $table->on('l.userid', '=', $queryBuilder->raw($userID));
        });



        $posts->select( array(
            $queryBuilder->raw('posts.id'),
            $queryBuilder->raw('posts.reach'),
            $queryBuilder->raw('posts.date_posted'),
            $queryBuilder->raw('posts.authorid'),
            $queryBuilder->raw('posts.latitude'),
            $queryBuilder->raw('posts.longitude'),
            $queryBuilder->raw('posts.content_type'),
            $queryBuilder->raw('posts.text'),
            $queryBuilder->raw('count(likes.id) as number_of_likes'),
            $queryBuilder->raw('count(comments.id) as number_of_comments'),
            $queryBuilder->raw('l.userid as likeuserid')

        ));

        $posts->groupBy('posts.id');


//        echo $posts->getQuery()->getRawSql();
        $responseData = $posts->get();



        foreach ($responseData as $post) {

            // Calculating distance and formatting this output
            $post_location = new Helpers\Location($post->latitude, $post->longitude);

            $distance = $post_location->distanceTo($requestLocation);

            $post->location = array(
                'distance' => $distance
            );
            unset($post->longitude);
            unset($post->latitude);


            // Formatting all date-types.
            $d = new DateTime($post->date_posted);

            $post->date_posted = $d->format('c');
            
            
            // Formatting the user-object
            $user = array(
                'id' => $post->authorid,
                'href' => $this->get('router')->pathFor('user', [
                    'id' => $post->authorid
                ])
            );
            $post->user = $user;
            unset($post->authorid);



            // TODO Check if user has liked
            $post->current_user_has_liked = true;




            // Format content
            if( $post->content_type == 'text') {
                $post->content = array(
                    'type' => 'text',
                    'text' => $post->text
                );
                unset($post->content_type);
                unset($post->text);
            }

            $post->href = $this->get('router')->pathFor('post', [
                'id' => $post->id
            ]);




            // Format current_user_has_liked
            $post->current_user_has_liked = !is_null($post->likeuserid);
            unset($post->likeuserid);


        }


        $newRes = $res->withJson(
           $responseData, null, JSON_NUMERIC_CHECK
        );

        return $newRes;
    })->setName('posts');









    /**
     * @api {get} /posts/ Create post
     * @apiName CreatePost
     * @apiGroup Post
     *
     * @apiParam {Number{-90 - 90}} latitude                            Latitude of the post to insert
     * @apiParam {Number{0 - 180}} longitude                            Longitude of the post to insert
     * @apiParam {String="text"} content_type ="text"                   The type of the content
     * @apiParam {String{..255}} [text]                                 If `content_type==text` this is mandatory.
     *
     * @apiParamExample {json} Request-Example
     *      {
     *          "latitude": 52.123123,
     *          "longitude": 11.123123,
     *          "content_type": "text",
     *          "text": "Lorem ipsum dolorem."
     *      }
     *
     *
     * @apiUse Unauthorized
     * @apiUse BadRequest
     */





    $app->post('/posts/', function( Request $req, Response $res, $args) {

        $post = $req->getParsedBody();


        // Validate latitude
        if( !isset($post['latitude']) ) {
            throw new BadRequestException('Latitude not set');
        }
        if(!Validator::floatType()->between(-90, 90)->validate( $post['latitude'] )) {
            throw new BadRequestException('Latitude malformed or out of range');
        }




        // Validate longitude
        if( !isset($post['longitude']) ) {
            throw new BadRequestException('Longitude not set');
        }
        if( !Validator::floatType()->between(0,180)->validate($post['longitude'] )) {
            throw new BadRequestException('Longitude malformed or out of range');
        }





        // Validate content type
        if( !isset($post['content_type'])) {
            throw new BadRequestException('Content type not set');
        }

        $allowedContentTypes = [ 'text' ];
        if( !in_array($post['content_type'], $allowedContentTypes)) {
            throw new BadRequestException('Content type not recognized');
        }





        // Validate content

        if( $post['content_type'] == 'text') {

            if( !isset($post['text'])) {
                throw new BadRequestException('Text not set');
            }

            if( !Validator::length(0,255)->validate( $post['text'])) {
                throw new BadRequestException('Text exceeds max limit of 255 characters');
            }


        }


        
        /** @var QueryBuilderHandler $qb */
        $qb = $this->querybuilder;

        // TODO Use authenticated users ID instead
        $userID = User::getInstance()->getUserId();


        $post['authorID'] = $userID;
        $qb->table('posts')->insert($post);

        return $res->withStatus(200)->withJson(
            array(
                'status' => 200
            )
        );



    });
