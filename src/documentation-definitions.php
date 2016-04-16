<?php
/**
 * @apiDefine Unauthorized Request was not authorized to do this action.
 *
 * @apiErrorExample Error-Response: Unauthorized
 *      HTTP/1.1 401 Unauthorized
 *      {
 *          "status": 401,
 *          "message": "Unauthorized Request"
 *      }
 */



/**
 * @apiDefine BadRequest Parameters missing or malformed
 *
 * @apiErrorExample Error-Response: Bad Request
 *      HTTP/1.1 400 Bad Request
 *      {
 *          "status": 400,
 *          "message": "Parameters missing or malformed"
 *      }
 */





/**
 * @apiDefine NotFound Resource not found
 *
 * @apiErrorExample Error-Response: Not Found
 *      HTTP/1.1 404 Not Found
 *      {
 *          "status": 404,
 *          "message": "Resource not found"
 *      }
 */