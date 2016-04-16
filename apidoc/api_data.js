define({ "api": [
  {
    "type": "get",
    "url": "/posts/",
    "title": "Create post",
    "name": "CreatePost",
    "group": "Post",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "size": "-90 - 90",
            "optional": false,
            "field": "latitude",
            "description": "<p>Latitude of the post to insert</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "size": "0 - 180",
            "optional": false,
            "field": "longitude",
            "description": "<p>Longitude of the post to insert</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"text\""
            ],
            "optional": false,
            "field": "content_type",
            "defaultValue": "text",
            "description": "<p>The type of the content</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "..255",
            "optional": true,
            "field": "text",
            "description": "<p>If <code>content_type==text</code> this is mandatory.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example",
          "content": "{\n    \"latitude\": 52.123123,\n    \"longitude\": 11.123123,\n    \"content_type\": \"text\",\n    \"text\": \"Lorem ipsum dolorem.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/endpoints/posts/archive.php",
    "groupTitle": "Post",
    "error": {
      "examples": [
        {
          "title": "Error-Response: Unauthorized",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"status\": 401,\n    \"message\": \"Unauthorized Request\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response: Bad Request",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"status\": 400,\n    \"message\": \"Parameters missing or malformed\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/posts/",
    "title": "List of Posts",
    "name": "GetPosts",
    "group": "Post",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "size": "-90 - 90",
            "optional": false,
            "field": "latitude",
            "description": "<p>The latitude of centerpoint which the posts will be around</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "size": "0 - 180",
            "optional": false,
            "field": "longitude",
            "description": "<p>The longitude of centerpoint which the posts will be around</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example",
          "content": "{\n    \"latitude\": 52.123123,\n    \"longitude\": 11.123123,\n}",
          "type": "json"
        }
      ]
    },
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
    "groupTitle": "Post",
    "error": {
      "examples": [
        {
          "title": "Error-Response: Unauthorized",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"status\": 401,\n    \"message\": \"Unauthorized Request\"\n}",
          "type": "json"
        }
      ]
    }
  }
] });
