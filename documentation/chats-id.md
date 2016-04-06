/chats/:id
==

# GET
Get `Chat` specified with `:id`

## Parameters
None.

## Return

### 200 - Success
	{
		"id": Integer,
		"status": String,
		"users": [
			{
				"id": Integer,
				"firstname": String,
				"lastname": String,
				"href": URL
			},
			...
		],
		"started_at": Date,
		"messages": [
			{
				"id": Integer,
				"user": {
					"id": Integer
				},
				"content": String,
				"sent_at": Date,
				"read_by": [
					{
						"id": Integer
					},
					...
				]
			}
		]

	}

