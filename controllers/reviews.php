<?php

class Reviews extends OBFController
{
  public function comment_add()
  {
    $this->user->require_permission('reviews_module');
    
    $this->user->require_permission('reviews_module');
    $media_id = trim($this->data('media_id'));
    $name = trim($this->data('name'));
    $email = trim($this->data('email'));
    $comment = trim($this->data('comment'));
    
    // validate
    if($media_id=='' || $name=='' || $email=='' || $comment=='') return [false, 'Required fields: media_id, name, email, comment.'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return [false, 'Email address is not valid.'];
    $this->db->where('id',$media_id);
    if(!$this->db->get_one('media')) return [false, 'Media item not found.'];

    
    // add comment
    $this->db->insert('module_reviews_comments', [
      'media_id' => $media_id,
      'name' => $name,
      'email' => $email,
      'comment' => $comment
    ]);
    
    return [true, 'Comment added.'];
  }
  
  public function comment_delete()
  {
    $this->user->require_permission('reviews_module');
    $id = trim($this->data('id'));
    $this->db->where('id',$id);
    $this->db->delete('module_reviews_comments');
    return [true, 'Comment deleted.'];
  }
  
  public function comment_get()
  {
    $media_id = trim($this->data('media_id'));
    $this->db->where('media_id',$media_id);
    $ratings = $this->db->get('module_reviews_comments');
    return [true, 'Comments', $ratings];
  }
  
  public function rating_add()
  {
    $this->user->require_permission('reviews_module');
    $media_id = trim($this->data('media_id'));
    $name = trim($this->data('name'));
    $email = trim($this->data('email'));
    $rating = trim($this->data('rating'));
    
    // validate
    if($media_id=='' || $name=='' || $email=='' || $rating=='') return [false, 'Required fields: media_id, name, email, rating.'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return [false, 'Email address is not valid.'];
    $this->db->where('id',$media_id);
    if(!$this->db->get_one('media')) return [false, 'Media item not found.'];
    
    // format rating
    $rating = (int) $rating;
    if($rating > 100) $rating = 100;
    if($rating < 0) $rating = 0;
    
    // delete existing rating from this user
    $this->db->where('media_id',$media_id);
    $this->db->where('email',$email);
    $this->db->delete('module_reviews_ratings');
    
    // add new rating
    $this->db->insert('module_reviews_ratings', [
      'media_id' => $media_id,
      'name' => $name,
      'email' => $email,
      'rating' => $rating
    ]);
    
    // update average rating
    $this->db->what('AVG(rating)','average',false);
    $this->db->where('media_id',$media_id);
    $row = $this->db->get_one('module_reviews_ratings');
    $average = round($row['average']);
    
    $this->db->where('media_id',$media_id);
    $this->db->update('media_metadata',[
      'reviews_module_rating' => $average
    ]);

    
    return [true, 'Rating added.'];
  }
  
  public function rating_delete()
  {
    $this->user->require_permission('reviews_module');
    $id = trim($this->data('id'));
    $this->db->where('id',$id);
    $this->db->delete('module_reviews_ratings');
    return [true, 'Rating deleted.'];
  }
  
  public function rating_get()
  {
    $media_id = trim($this->data('media_id'));
    $this->db->where('media_id',$media_id);
    $ratings = $this->db->get('module_reviews_ratings');
    return [true, 'Ratings', $ratings];
  }
}