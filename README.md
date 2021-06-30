# Reviews

The Reviews module provides comment and ratings support for media items. Comments and ratings can be added (and deleted) via API requests only; the module is designed to integrate with another website. Adding a rating will also update a custom metadata field with the average rating in order to allow for searches and dynamic selections based on good (or poor) ratings.

See http://docs.openbroadcaster.com/ for general API integration instructions. An appkey is required on a user with the "manage media reviews via api" permission. As this permission gives broad access to add and remove ratings and reviews, any integration should be done server-side to avoid providing end users with access credentials (i.e., in JavaScript source code).

## Installation

1. Add the module code to /modules/reviews and install the module via the OpenBroadcaster "modules" page.
2. Add a custom metadata field (integer) with the name "reviews_module_rating" to hold the average rating value (0-100).

## API Methods

The following methods are available for the controller "review".

### comment_add

Add a comment to a media item. Multiple comments per user/email are allowed.

| Parameter | Description |
| --- | --- |
| media_id | media id |
| name | user's name |
| email | user's email |
| comment | comment |

### comment_delete

Delete a comment.

| Parameter | Description |
| --- | --- |
| id | comment id |

### comment_get

Get all comments. Note this method is available to any logged in OpenBroadcaster user (or any user via appkeys).

| Parameter | Description |
| --- | --- |
| media_id | media id |

### rating_add

Add a rating to a media item. If a rating already exists for this email address, it will be replaced.

| Parameter | Description |
| --- | --- |
| media_id | media id |
| name | user's name |
| email | user's email |
| rating | rating (0-100) |

### rating_delete

Delete a rating.

| Parameter | Description |
| --- | --- |
| id | rating id |

### rating_get

Get all ratings. Note this method is available to any logged in OpenBroadcaster user (or any user via appkeys).

| Parameter | Description |
| --- | --- |
| media_id | media id |
