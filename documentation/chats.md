/chats
==


# GET
Retrieve authenticated `User`s `Chat`s.

## Parameters
* `status`: String (requested/pending/accepted) Defaults to accepted

## Return

### 200 - Success
	{
		"chats": [
			{
				"id": Integer,
				"users": [
					{
						"id": Integer,
						"first_name": String,
						"last_name": String,
						"href": URL,
					},
					...
				],
				"started_at": Date,
				"unread_messages": Integer
			}
		]
	}







# POST
Create a new `Chat` with `User`.

## Parameters
* `user_id`: Integer (required)

## Return

#### 200 - Success
	{
		"chat": {
			"id": Integer,
			"users": [
				{
					"id": Integer,
					"first_name": String,
					"last_name": String,
					"href": URL
				}
			],
			"started_at": Date,
			"unread_messages"
		}
	}
