<?php
ini_set('max_execution_time', 0); 
# Include the Dropbox SDK libraries
require_once "vendor/autoload.php";
use \Kunnu\Dropbox as dbx;

$filePath = isset( $_REQUEST['path'] ) ? $_REQUEST['path'] : '';
if( $filePath != '' )
{
	try {
		
		$dbxApp 	 		= new dbx\DropboxApp('Your App key','Your App secret','Your Access Token');
		$dbxClient   		= new dbx\Dropbox($dbxApp);
		$result = $dbxClient->getTemporaryLink($filePath);               
		if( $result->link != '' )
		{
			header('Location: '.$result->link);
		}
	}
	//catch exception
	catch(Exception $e) {
		echo "<p>".$e->getMessage()."</p>";    
	}            
}
?>
