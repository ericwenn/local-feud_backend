define({ "api": [
  {
    "type": "get",
    "url": "/posts/:id/comments/",
    "title": "Comments on a Post",
    "group": "Comment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID of Post</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "comments",
            "description": "<p>The Comments</p>"
          },
          {
            "group": "Success 200",
            "type": "Date",
            "optional": false,
            "field": "comments.date_posted",
            "description": "<p>Date when the comment was created</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "comments.is_original_poster",
            "description": "<p>If the User is also the Author of the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "comments.content",
            "description": "<p>The Comments content</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "comments.user",
            "description": "<p>The User who created the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "comments.user.firstname",
            "description": "<p>Firstname of the User</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "comments.user.lastname",
            "description": "<p>Lastname of the User</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "comments.user.id",
            "description": "<p>ID of the User</p>"
          },
          {
            "group": "Success 200",
            "type": "URL",
            "optional": false,
            "field": "comments.user.href",
            "description": "<p>Reference to the endpoint</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "src/endpoints/posts/single-comments.php",
    "groupTitle": "Comment",
    "name": "GetPostsIdComments",
    "sampleRequest": [
      {
        "url": "http://api-local.ericwenn.se/posts/:id/comments/"
      }
    ]
  },
  {
    "type": "post",
    "url": "/posts/:id/comments/",
    "title": "Comment a Post",
    "group": "Comment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID of Post</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>The content of the comment</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "src/endpoints/posts/single-comments.php",
    "groupTitle": "Comment",
    "name": "PostPostsIdComments",
    "sampleRequest": [
      {
        "url": "http://api-local.ericwenn.se/posts/:id/comments/"
      }
    ],
    "error": {
      "examples": [
        {
          "title": "Error-Response: Unauthorized",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"status\": 401,\n    \"message\": \"Unauthorized Request\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response: Not Found",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": 404,\n    \"message\": \"Resource not found\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "/posts/:id/likes/",
    "title": "Remove Like on Post",
    "group": "Like",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID of Post</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "src/endpoints/posts/single-likes.php",
    "groupTitle": "Like",
    "name": "DeletePostsIdLikes",
    "sampleRequest": [
      {
        "url": "http://api-local.ericwenn.se/posts/:id/likes/"
      }
    ],
    "error": {
      "examples": [
        {
          "title": "Error-Response: Unauthorized",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"status\": 401,\n    \"message\": \"Unauthorized Request\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response: Not Found",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": 404,\n    \"message\": \"Resource not found\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/posts/:id/likes/",
    "title": "Likes on a Post",
    "group": "Like",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID of Post</p>"
          }
        ]
      }
    },
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
            "type": "Date",
            "optional": false,
            "field": "likes.date_liked",
            "description": "<p>Date when the Post was liked</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "likes.is_original_poster",
            "description": "<p>If the User is also the Author of the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "likes.user",
            "description": "<p>The User who created the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "likes.user.firstname",
            "description": "<p>Firstname of the User</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "likes.user.lastname",
            "description": "<p>Lastname of the User</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "likes.user.id",
            "description": "<p>ID of the User</p>"
          },
          {
            "group": "Success 200",
            "type": "URL",
            "optional": false,
            "field": "likes.user.href",
            "description": "<p>Reference to the endpoint</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "src/endpoints/posts/single-likes.php",
    "groupTitle": "Like",
    "name": "GetPostsIdLikes",
    "sampleRequest": [
      {
        "url": "http://api-local.ericwenn.se/posts/:id/likes/"
      }
    ]
  },
  {
    "type": "post",
    "url": "/posts/:id/likes/",
    "title": "Like a Post",
    "group": "Like",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID of Post</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "src/endpoints/posts/single-likes.php",
    "groupTitle": "Like",
    "name": "PostPostsIdLikes",
    "sampleRequest": [
      {
        "url": "http://api-local.ericwenn.se/posts/:id/likes/"
      }
    ],
    "error": {
      "examples": [
        {
          "title": "Error-Response: Unauthorized",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"status\": 401,\n    \"message\": \"Unauthorized Request\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response: Not Found",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": 404,\n    \"message\": \"Resource not found\"\n}",
          "type": "json"
        }
      ]
    }
  },
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
    "sampleRequest": [
      {
        "url": "http://api-local.ericwenn.se/posts/"
      }
    ],
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
    "url": "/posts/:id/",
    "title": "Single Post",
    "name": "GetPost",
    "group": "Post",
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
            "type": "Object[]",
            "optional": false,
            "field": "comments",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "comments.number_of_comments",
            "description": "<p>Number of Comments on the Post</p>"
          },
          {
            "group": "Success 200",
            "type": "URL",
            "optional": false,
            "field": "comments.href",
            "description": "<p>Reference to the posts comments</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "likes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "likes.number_of_likes",
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
    "groupTitle": "Post",
    "sampleRequest": [
      {
        "url": "http://api-local.ericwenn.se/posts/:id/"
      }
    ],
    "error": {
      "examples": [
        {
          "title": "Error-Response: Unauthorized",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"status\": 401,\n    \"message\": \"Unauthorized Request\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response: Not Found",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": 404,\n    \"message\": \"Resource not found\"\n}",
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
    "sampleRequest": [
      {
        "url": "http://api-local.ericwenn.se/posts/"
      }
    ],
    "error": {
      "examples": [
        {
          "title": "Error-Response: Unauthorized",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"status\": 401,\n    \"message\": \"Unauthorized Request\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "/posts/:id/reports/",
    "title": "Unreport a post",
    "group": "Report",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID of Post</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "src/endpoints/posts/single-reports.php",
    "groupTitle": "Report",
    "name": "DeletePostsIdReports",
    "sampleRequest": [
      {
        "url": "http://api-local.ericwenn.se/posts/:id/reports/"
      }
    ],
    "error": {
      "examples": [
        {
          "title": "Error-Response: Unauthorized",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"status\": 401,\n    \"message\": \"Unauthorized Request\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response: Not Found",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": 404,\n    \"message\": \"Resource not found\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/posts/:id/reports/",
    "title": "Report a post",
    "group": "Report",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID of Post</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "src/endpoints/posts/single-reports.php",
    "groupTitle": "Report",
    "name": "PostPostsIdReports",
    "sampleRequest": [
      {
        "url": "http://api-local.ericwenn.se/posts/:id/reports/"
      }
    ],
    "error": {
      "examples": [
        {
          "title": "Error-Response: Unauthorized",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"status\": 401,\n    \"message\": \"Unauthorized Request\"\n}",
          "type": "json"
        },
        {
          "title": "Error-Response: Not Found",
          "content": "HTTP/1.1 404 Not Found\n{\n    \"status\": 404,\n    \"message\": \"Resource not found\"\n}",
          "type": "json"
        }
      ]
    }
  }
] });
