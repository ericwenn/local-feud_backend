<?php
    namespace LocalFeud;
/**
 * @api {get} /posts/ List of Posts
 * @apiName GetPosts
 * @apiGroup Posts
 *
 * @apiSuccess {Object[]}	posts 					    The Posts
 * @apiSuccess {Number} 	posts.id 				    ID of the Post
 * @apiSuccess {Number}	    posts.reach				    Reach of the Post, measured in kilometers
 * @apiSuccess {Date}		posts.date_posted		    Date when the Post was created
 * @apiSuccess {Number}	    posts.number_of_comments    Number of Comments on the Post
 * @apiSuccess {Number}	    posts.number_of_likes       Number of Likes on the Post
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
 */

	use DateTime;

    $app->get('/posts/', function($req, $res, $args ) {

        // Get-parameters not added yet. These points *should* be in Gothenburg.
        $fake_latitude = 52.23123;
        $fake_longitude = 11.123123;

        $requestLocation = new Helpers\Location($fake_latitude, $fake_longitude);


        $posts = \QB::table('posts');

        // Joining to post_commentators, which holds the name for everyone connected to this post.
        $posts->leftJoin('post_commentators', 'posts.id', '=', 'post_commentators.postid');


        $posts->select( array(
            \QB::raw('posts.id'),
            \QB::raw('posts.reach'),
            \QB::raw('posts.date_posted'),
            \QB::raw('posts.authorid'),
            \QB::raw('posts.latitude'),
            \QB::raw('posts.longitude'),

        ));


        try {
            // echo $posts->getQuery()->getRawSql();
            $responseData = $posts->get();
        } catch(Exception $e) {

            // TODO Fix this error handling
            echo $e->getMessage();
        }


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


            // Data not yet implemented
            $post->number_of_comments = 4;
            $post->number_of_likes = 10;

            $post->content = array(
                'type' => 'text',
                'text' => 'Lorem ipsum'
            );

            $post->href = $this->get('router')->pathFor('post', [
                'id' => $post->id
            ]);


        }

        /**
        $date = new Date();
        $dummyResponse = array(
            array(
                'id' => 1,
                'location' => array(
                    'distance' => 5
                ),
                'user' => array(
                    'id' => 1,
                    'firstname' => 'Karl',
                    'lastname' => 'Karlsson',
                    'href' => API_ROOT_URL . '/users/1/'
                ),
                'reach' => 5,
                'content' => array(
                    'type' => 'text',
                    'text' => 'Lorem ipsum dolorem.'
                ),
                'number_of_comments' => 10,
                'number_of_likes' => 20,
                'date_posted' => $date->format('c'),
                'href' => API_ROOT_URL . '/posts/1/'
            ),
            array(
                'id' => 2,
                'location' => array(
                    'distance' => 7
                ),
                'user' => array(
                    'id' => 2,
                    'firstname' => 'Krune',
                    'lastname' => 'Nilsson',
                    'href' => API_ROOT_URL . '/users/2/'
                ),
                'reach' => 5,
                'content' => array(
                    'type' => 'text',
                    'text' => 'Lorem ipsum dolorem.'
                ),
                'number_of_comments' => 10,
                'number_of_likes' => 20,
                'date_posted' => $date->format('c'),
                'href' => API_ROOT_URL . '/posts/2/'
            )
        );
        */

        $newRes = $res->withJson(
           $responseData
        );

        return $newRes;
    })->setName('posts');
	
	$app->post('/posts.php', function($req, $res, $args ) {
		
		$postpost = \QB::table('posts');
		
		$argstopost = $request->getParsedBody();

        $insert = array(
           'reach' -> $argstopost['reach'],
           'authorid' -> $argstopost['authorid'],
           'latitude' ->  $argstopost['latitude'],
           'longitude' ->  $argstopost['longitude']
        );

        try
		{
            $responseData = $postpost->insert($insert);
        }
		catch(Exception $e)
		{
            echo $e->getMessage();
        }
		
	}->setName('posts');