OBModules.Reviews = {}

OBModules.Reviews.init = function()
{
  OB.Callbacks.add('ready',0,OBModules.Reviews.init2);
}

OBModules.Reviews.init2 = function()
{
  function_append('OB.UI.replaceMain', 'OBModules.Reviews.load');
}

OBModules.Reviews.load = function()
{
  // return if not on media details page
  if($('#layout_main').attr('data-src')!='media/details.html') return;
  
  // add our reviews tab
  $('#layout_main ob-tabs').append('<ob-tab data-name="Reviews"><p>Loading...</p></ob-tab');
  
  var post = [];
  post.push(['reviews','comment_get',{'media_id': $('#layout_main').attr('data-media_id')}]);
  post.push(['reviews','rating_get',{'media_id': $('#layout_main').attr('data-media_id')}]);
  
  OB.API.multiPost(post,function(response)
  {
    var comments = response[0].data;
    var ratings = response[1].data;
    var $comments = $('<div id="reviews-comments"></div>').html('<h1>Comments</h1>');
    var $ratings = $('<div id="reviews-ratings"></div>').html('<h1>Ratings</h1>');
    
    $.each(comments, function(index, comment)
    {
      var $comment = $('<div class="reviews-comment"></div>');
      $comment.append( $('<div class="reviews-comment-datetime"></div>').text(comment.created) );
      $comment.append( $('<div class="reviews-comment-author"></div>').text(comment.name+' ('+comment.email+')') );
      $comment.append( $('<div class="reviews-comment-comment"></div>').text(comment.comment) );
      $comments.append($comment);
    });
    
    $.each(ratings, function(index, rating)
    {
      var $rating = $('<div class="reviews-rating"></div>');
      $rating.append( $('<div class="reviews-rating-datetime"></div>').text(rating.created) );
      $rating.append( $('<div class="reviews-rating-author"></div>').text(rating.name+' ('+rating.email+')') );
      $rating.append( $('<div class="reviews-rating-rating"></div>').text(rating.rating+'%') );
      $ratings.append($rating);
    });
    
    $('#layout_main ob-tab[data-name=Reviews]').empty().append($comments).append($ratings);
  });
}