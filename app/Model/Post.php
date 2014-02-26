<?php
class Post extends AppModel {
	public $validate = array(
        'title' => 'notEmpty',
		'body' => 'notEmpty'
    );
}

?>