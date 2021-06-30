<?php

class ReviewsModule extends OBFModule
{

	public $name = 'Reviews';
	public $description = 'Provide rating and comment functionality for media.';

	public function callbacks()
	{

	}

	public function install()
	{
    $this->db->query('CREATE TABLE IF NOT EXISTS `module_reviews_ratings` (
			`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			`media_id` int(10) UNSIGNED NOT NULL,
			`name` varchar(255) NOT NULL,
			`email` varchar(255) NOT NULL,
			`rating` tinyint(3) UNSIGNED NOT NULL,
			`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `media_id` (`media_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');

    $this->db->query('ALTER TABLE `module_reviews_ratings`
  		ADD CONSTRAINT `module_reviews_ratings_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');

		$this->db->query('CREATE TABLE IF NOT EXISTS `module_reviews_comments` (
			`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			`media_id` int(10) UNSIGNED NOT NULL,
			`name` varchar(255) NOT NULL,
			`email` varchar(255) NOT NULL,
			`comment` text NOT NULL,
			`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			KEY `media_id` (`media_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');
	
		$this->db->query('ALTER TABLE `module_reviews_comments`
  		ADD CONSTRAINT `module_reviews_comments_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');

		$this->db->insert('users_permissions', [
			'category'=>'administration',
			'description'=>'manage media reviews via api',
			'name'=>'reviews_module'
		]);

    return true;
	}

	public function uninstall()
	{
		// remove permissions data for this module
		$this->db->where('name','reviews_module');
		$permission = $this->db->get_one('users_permissions');

		$this->db->where('permission_id',$permission['id']);
		$this->db->delete('users_permissions_to_groups');

		$this->db->where('id',$permission['id']);
		$this->db->delete('users_permissions');

		return true;
	}
}
