<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php
# Include the Dropbox SDK libraries
require_once "vendor/autoload.php";
use \Kunnu\Dropbox as dbx;

$accessToken 		= "_gaOMfYC23AAAAAAAAADPcEGme5ToXsEN_hZsYuJUgY";
$dbxApp 	 		= new dbx\DropboxApp('suguuqcyxtjo5qb','gmqiwhwcy65v5df','d8O1b7pcvqAAAAAAAAAABviuBjEYXLaV0gFUOWrBz4YkETT1tB_-wPzd3ohcH-Yr');
$accountInfo 		= $dbxApp->getClientId();
$dbxClient   		= new dbx\Dropbox($dbxApp);
$listFolderContents = $dbxClient->listFolder("/");

$entries 	= $listFolderContents->entries;
foreach ($entries as $key => $value)
{
	if( $value['.tag'] == 'folder' )
	{
		getItems($value['path_lower']);		
	}
	else
	{
		$_POST[] = $value;
	}
}

function getItems( $path = null )
{
	$accessToken = "_gaOMfYC23AAAAAAAAADPcEGme5ToXsEN_hZsYuJUgY";

	$dbxApp = new dbx\DropboxApp('suguuqcyxtjo5qb','gmqiwhwcy65v5df','d8O1b7pcvqAAAAAAAAAABviuBjEYXLaV0gFUOWrBz4YkETT1tB_-wPzd3ohcH-Yr');
	$accountInfo = $dbxApp->getClientId();
	$dbxClient = new dbx\Dropbox($dbxApp);
	if( $path != null )
	{
		$listFolderContents = $dbxClient->listFolder($path."/");
		$subitems 		    = $listFolderContents->getItems();
		if( !empty($subitems))
		{
			foreach ($subitems as $key1 => $value1)
			{
				$value1=$value1->getData();				
				if( $value1['.tag'] == 'file' )
				{
					$itemm['name'] 			  = $value1['name'];
					$itemm['.tag'] 			  = $value1['.tag'];
					$itemm['path_lower'] 	  = $value1['path_lower'];
					$itemm['path_display']    = $value1['path_display'];
					$itemm['id'] 			  = $value1['id'];
					$itemm['client_modified'] = $value1['client_modified'];
					$itemm['server_modified'] = $value1['server_modified'];
					$itemm['rev'] 			  = $value1['rev'];
					$itemm['size'] 			  = $value1['size'];
					$itemm['content_hash'] 	  = $value1['content_hash'];
					$_POST[] = $itemm;
				}
				else if( $value1['.tag'] == 'folder' )
				{
					$subitems = getItems($value1['path_lower']);					
				}
			}
		}
		
	}			
	else
		return array();
	
}

//echo "<pre>";print_r($_POST);

?>
<div class="container">
  <h2>Drop Box Files</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>File Name</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
	<?php if( !empty($_POST) ) {
		foreach( $_POST as $keyy=>$vall ){?>
		<tr>
		<td><?php echo $vall['name'];?></td>
		<td><a target="_blank" href="<?php echo 'download.php?path='.$vall['path_lower'];?>">Click Here To Download</a></td>
		</tr>
		<?php } 
	} ?>
    </tbody>
  </table>
</div>

</body>
</html>
