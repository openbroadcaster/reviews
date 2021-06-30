# Reviews

The Reviews module provides comment and ratings support for media items. Comments and ratings can be added (and deleted) via API requests only; the module is designed to integrate with another website. Adding a rating will also update a custom metadata field with the average rating in order to allow for searches and dynamic selections based on good (or poor) ratings.

See http://docs.openbroadcaster.com/ for general API integration instructions. An appkey is required on a user with the "manage media reviews via api" permission. As this permission gives broad access to add and remove ratings and reviews, any integration should be done server-side to avoid providing end users with access credentials (i.e., in JavaScript source code).
