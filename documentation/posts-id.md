# /posts/:id
## GET
Get `Post` object specified by `:id`.

### Parameters
None.


### Return

#### 200 - OK

	{
		"id": Integer,
		"user": {
			"id": Integer,
			"firstname": String,
			"lastname": String,
			"href": String
		},
		"reach": Integer,
		"is_deleted": Boolean,
		"location": {
			"latitude": Float,
			"longitude": Float,
			"distance": Integer
		},
		"date_posted": Date,
		"comments": [
			{
				"id": Integer,
				"user": {
					"id": Integer,
					"firstname": String,
					"lastname": String,
					"href": String
				},
				"content": String,
				"date_posted": Date,
				"is_original_poster": Boolean,
				"href": URL
			},
			...
		]
	}





## DELETE
Delete `Post` object specified by `:id`. Can only be performed by `Author` of `Post`.


### Return

#### 200 - OK
	{
		status: 200
	}

#### 403 - Forbidden
Returned when Authenticated `User` is not the `Author` of `Post`.
	{
		status: 403
	}