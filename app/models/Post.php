<?php

class Post extends Eloquent {
	protected $fillable = array('title', 'meta-keywords', 'body');
}