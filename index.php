<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dropbox File List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
  <link rel="shortcut icon" type="image/png" href="https://raw.githubusercontent.com/jaraco/dropbox-index/master/icons/favicon.ico"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" />
</head>
<body>

<?php
# Include the Dropbox SDK libraries
require_once "vendor/autoload.php";
use \Kunnu\Dropbox as dbx;
$root  = "http://".$_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

$flag  = isset( $_REQUEST['flag'] ) ? $_REQUEST['flag'] : 0;
ini_set('max_execution_time', 0); 
if( $flag == 1 )
{
	$dbxApp 	 		= new dbx\DropboxApp('Your App key','Your App secret','Your Access Token');
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
			$itemm['name'] 			  = $value1['name'];
			$itemm['path_lower'] 	  = $value1['path_lower'];
			$_POST[] = $itemm;
		}
	}
}

function getItems( $path = null )
{
	
	$dbxApp 	 		= new dbx\DropboxApp('Your App key','Your App secret','Your Access Token');
	$accountInfo = $dbxApp->getClientId();
	$dbxClient   = new dbx\Dropbox($dbxApp);
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
					$itemm['path_lower'] 	  = $value1['path_lower'];
					/*$itemm['.tag'] 			  = $value1['.tag'];
					$itemm['path_display']    = $value1['path_display'];
					$itemm['id'] 			  = $value1['id'];
					$itemm['client_modified'] = $value1['client_modified'];
					$itemm['server_modified'] = $value1['server_modified'];
					$itemm['rev'] 			  = $value1['rev'];
					$itemm['size'] 			  = $value1['size'];
					$itemm['content_hash'] 	  = $value1['content_hash'];*/
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

?>
<div class="container">
	<?php if( $flag == 0 ){?>
		<h2></h2>
		<div class="row">
			<div class="form-group">
				<div class="col-md-12 text-center"> 
					<a href="<?php echo $root.'?flag=1';?>" class="btn btn-primary">List Dropbox Files</a>
				</div>
			</div>

		</div>		
	<?php } else{?>	
		<h2>Drop Box Files</h2>
		<table id="example" class="table table-striped table-bordered" style="width:100%">
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
			} else{?>
				<tr>
					<td colspan="2">No files found.</td>					
				</tr>
			<?php } ?>	
			</tbody>
		</table>
		
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				//$('#example').DataTable();
				$('#example').dataTable( {
				  "pageLength": 25,
				  "lengthMenu": [[10, 25, 50, 100, 150, -1], [10, 25, 50, 100, 150, "All"]]
				} );
			} );
		</script>
	<?php } ?>
</div>

</body>
</html>
