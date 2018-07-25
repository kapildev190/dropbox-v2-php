<?php
ini_set('max_execution_time', 0); 
# Include the Dropbox SDK libraries
require_once "vendor/autoload.php";
use \Kunnu\Dropbox as dbx;

$filePath = isset( $_REQUEST['path'] ) ? $_REQUEST['path'] : '';
if( $filePath != '' )
{
	try {
		$dbxApp 	 		= new dbx\DropboxApp('pkj3wpminfit30i','mgdesun91cmiokv','7oYNdBjOuoAAAAAAAAAEr1uVMlPDy3NNsl74VeI_ohIfPVHe3fWCrxUYF-bEf4qE');
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
