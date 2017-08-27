<?php
# debug
$url = $_SERVER['REQUEST_URI'];// for the url traitment
define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);// for the include path
printf("Wanted url %s on os path %s <br />",$url,ROOT);

# secure input(of course in real world, data from form by POST)
$id=( isset($_GET['id']) AND ctype_digit($_GET['id']) )?$_GET['id']:'';// do controls you want
$severity=( isset($_GET['severity']) AND ctype_digit($_GET['severity']) )?$_GET['severity']:'';
$urgency=( isset($_GET['urgency']) AND ctype_digit($_GET['urgency']) )?$_GET['urgency']:'';
$status=( isset($_GET['status']) AND ctype_digit($_GET['status']) )?$_GET['status']:'';
$title=( isset($_GET['title']) )?$_GET['title']:''; // to protect : do later in pdo
$description=( isset($_GET['description']) )?$_GET['description']:'';
$act=( isset($_GET['act']) )?$_GET['act']:'';

# bootstrap
require_once(ROOT.'/Conf/Connection.php');
require_once(ROOT.'/Model/Model.php');// with autoloader or psr...

/* 
# connection : version IC forced
$myConnection=new Connection();
$myModel = new Model($myConnection);
*/

# class to object
$myModel = new Model();//--- version IC with connection by default

# quickly need controller...
switch($act){
	case 'c':
		$myModel->setTitle($title);echo $myModel->title;
		$myModel->setDescription($description);
		$myModel->setSeverity($severity);
		$myModel->setUrgency($urgency);
		$result = $myModel->create_one();
		print_r($result);
	break;
	case 'r':
		$myModel->setId($id);
		$result = $myModel->retrieve_one();
		print_r($result);
	break;
	case 'u':
		$myModel->setId($id);
		$myModel->setTitle($title);
		$myModel->setDescription($description);
		$myModel->setSeverity($severity);
		$myModel->setUrgency($urgency);
		$myModel->setStatus($status);
		$result = $myModel->update_one();
		print_r($result);
	break;
	case 'd':
		$myModel->setId($id);
		$result = $myModel->delete_one();
		print_r($result);
	break;
	default:
	break;
}



?>