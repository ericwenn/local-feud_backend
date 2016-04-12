define({ "api": [
  {
    "type": "get",
    "url": "/posts/{id}/",
    "title": "Single Post",
    "name": "GetPost",
    "group": "Posts",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID of the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "reach",
            "description": "<p>Reach of the Post, measured in kilometers</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "date_posted",
            "description": "<p>Date when the Post was created</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "number_of_comments",
            "description": "<p>Number of Comments on the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "number_of_likes",
            "description": "<p>Number of Likes on the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "user",
            "description": "<p>The User who created the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "user.id",
            "description": "<p>ID of the User</p>"
          },
          {
            "group": "Success 200",
            "type": "URL",
            "optional": false,
            "field": "user.href",
            "description": "<p>Reference to the Users endpoint</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "content",
            "description": "<p>The content of the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "content.type",
            "description": "<p>The type of content the Post has</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "content.text",
            "description": "<p>The text of the Post. Only returned if content.type == 'text'</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "content.image_src",
            "description": "<p>URL of Posts image. Only returned if content.type == 'image'</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "location",
            "description": "<p>Information of the location of the Post.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "location.distance",
            "description": "<p>Number between 0 and 10 denoting the distance from the post</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "location.latitude",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "location.longitude",
            "description": ""
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "src/endpoints/posts/single.php",
    "groupTitle": "Posts"
  },
  {
    "type": "get",
    "url": "/posts/",
    "title": "List of Posts",
    "name": "GetPosts",
    "group": "Posts",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "posts",
            "description": "<p>The Posts</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "posts.id",
            "description": "<p>ID of the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "posts.reach",
            "description": "<p>Reach of the Post, measured in kilometers</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "posts.date_posted",
            "description": "<p>Date when the Post was created</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "posts.number_of_comments",
            "description": "<p>Number of Comments on the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "posts.number_of_likes",
            "description": "<p>Number of Likes on the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "posts.user",
            "description": "<p>The User who created the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "posts.user.id",
            "description": "<p>ID of the User</p>"
          },
          {
            "group": "Success 200",
            "type": "URL",
            "optional": false,
            "field": "posts.user.href",
            "description": "<p>Reference to the endpoint</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "posts.content",
            "description": "<p>The content of the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "posts.content.type",
            "description": "<p>The type of content the Post has</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "posts.content.text",
            "description": "<p>The text of the Post. Only returned if content.type == 'text'</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "posts.content.image_src",
            "description": "<p>URL of Posts image. Only returned if content.type == 'image'</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "posts.location",
            "description": "<p>Information of the location of the Post.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "posts.location.distance",
            "description": "<p>Number between 0 and 10 denoting the distance from the post</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "posts.href",
            "description": "<p>Reference to the endpoint</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "src/endpoints/posts/archive.php",
    "groupTitle": "Posts"
  },
  {
    "type": "get",
    "url": "/posts/[id]/likes/",
    "title": "Likes on a Post",
    "group": "Posts",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "likes",
            "description": "<p>The Likes</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "likes.id",
            "description": "<p>ID of the Like</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "posts.date_liked",
            "description": "<p>Date when the Post was liked</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "posts.is_original_poster",
            "description": "<p>If the User is also the Author of the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "posts.user",
            "description": "<p>The User who created the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "posts.user.firstname",
            "description": "<p>Firstname of the User</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "posts.user.lastname",
            "description": "<p>Lastname of the User</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "posts.user.id",
            "description": "<p>ID of the User</p>"
          },
          {
            "group": "Success 200",
            "type": "URL",
            "optional": false,
            "field": "posts.user.href",
            "description": "<p>Reference to the endpoint</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "src/endpoints/posts/single-likes.php",
    "groupTitle": "Posts",
    "name": "GetPostsIdLikes"
  }
] });
