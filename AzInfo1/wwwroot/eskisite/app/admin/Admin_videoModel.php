<?php

class Admin_videoModel extends AdminModel
{
	public $_tableName = 'video';
	public $_primaryKey = 'video_id';
	
	public $_gridTitle = 'Videolar';
	public $_itemTitle = 'Video';
	public $_editFormClass = 'Admin_videoForm';
	
	public $_relations = array();
	
}
