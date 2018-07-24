<?php
ini_set('max_execution_time', 600); //300 seconds = 5 minutes

ini_set('max_execution_time', 0); //0=NOLIMIT
# Include the Dropbox SDK libraries
require_once "vendor/autoload.php";
use \Kunnu\Dropbox as dbx;

$filePath = isset( $_REQUEST['path'] ) ? $_REQUEST['path'] : '';
if( $filePath != '' )
{
	$accessToken 		= "_gaOMfYC23AAAAAAAAADPcEGme5ToXsEN_hZsYuJUgY";
	$dbxApp 	 		= new dbx\DropboxApp('suguuqcyxtjo5qb','gmqiwhwcy65v5df','d8O1b7pcvqAAAAAAAAAABviuBjEYXLaV0gFUOWrBz4YkETT1tB_-wPzd3ohcH-Yr');
	$accountInfo 		= $dbxApp->getClientId();
	$dbxClient   		= new dbx\Dropbox($dbxApp);

	//$file = $dbxClient->download("/second folder/first sub folder in second folder/first file.txt", 'first file.txt');
	$file = $dbxClient->download($filePath, 'first file.txt');
	//Get File Contents
	$contents = $file->getContents();
	//Save File Contents to Disk
	//file_put_contents(__DIR__ . "/first file2.txt", $contents);
	file_put_contents(__DIR__ . "/first file2.pdf", $contents);
	$path = __DIR__ . "/first file2.pdf";
	$filename = "firstfile2.pdf";
	header('Content-Transfer-Encoding: binary');  // For Gecko browsers mainly
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
	header('Accept-Ranges: bytes');  // Allow support for download resume
	header('Content-Length: ' . filesize($path));  // File size
	header('Content-Encoding: none');
	header('Content-Type: application/pdf');  // Change the mime type if the file is not PDF
	header('Content-Disposition: attachment; filename=' . $filename);  // Make the browser display the Save As dialog
	readfile($path);
}
?>
