<?php
# Include the Dropbox SDK libraries
require_once "vendor/autoload.php";
use \Kunnu\Dropbox as dbx;

//$appInfo = dbx\AppInfo::loadFromJsonFile("app-info.json");
//$webAuth = new dbx\WebAuthNoRedirect($appInfo, "PHP-Example/2.0");

//echo    $authorizeUrl = $webAuth->start();

//echo "\n 1. Go to: " . $authorizeUrl . "\n";
//echo "\n 2. Click \"Allow\" (you might have to log in first).\n";
//echo "\n 3. Copy the authorization code.\n";
///$authCode = "_gaOMfYC23AAAAAAAAAACl0Z2KlvR8CP3uGs8m_1ATI";

$accessToken = "_gaOMfYC23AAAAAAAAADPcEGme5ToXsEN_hZsYuJUgY";

$dbxApp = new dbx\DropboxApp('suguuqcyxtjo5qb','gmqiwhwcy65v5df','d8O1b7pcvqAAAAAAAAAABviuBjEYXLaV0gFUOWrBz4YkETT1tB_-wPzd3ohcH-Yr');
$accountInfo = $dbxApp->getClientId();
//echo "<pre>";print_r($accountInfo);

$dbxClient = new dbx\Dropbox($dbxApp);

//$client = $dbxClient->getClient();
//$client = $dbxClient->createFolder('/sarbrinder');

//echo "<pre>##############################################";print_r($client);

//$f = fopen("dp1.jpg", "rb");
//$result = $dbxClient->upload("dp1.jpg","/sarbrinder/dp1.jpg");

//$result = $dbxClient->listFolder('/');

//fclose($f);
//echo "<pre>**********************************************"; print_r($result);

$listFolderContents = $dbxClient->listFolder("/");
//echo "<pre>";print_r($listFolderContents);die('lol');
$entries = $listFolderContents->entries;
echo "<pre>";print_r($entries);die;
$newItems = array();
foreach ($entries as $key => $value)
{
	if( $value['.tag'] == 'folder' )
	{
		$listFolderContents = $dbxClient->listFolder($value['path_lower']."/");
		//Fetch Items (Returns an instance of ModelCollection)
		$items = array();
		$items = $listFolderContents->getItems();
				
		if( !empty($items))
		{
			foreach ($items as $key1 => $value1)
			{
				$value1=$value1->getData();				
				//echo $isFile=$value1->getData()['.tag']==='file';				
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
					$newItems[] = $itemm;
				}
				else if( $value1['.tag'] == 'folder' )
				{
					$subitems = getItems($value1['path_lower']);
					if( !empty($subitems))
					{
						echo "<pre>";print_r($items);
						echo "<pre>";print_r($subitems);
						$items = array_merge($items,$subitems);
					}
				}
			}
		}
	}
	else
	{
		$newItems[] = $value;
	}


}

function getItems( $path = null )
{
	$accessToken = "_gaOMfYC23AAAAAAAAADPcEGme5ToXsEN_hZsYuJUgY";

	$dbxApp = new dbx\DropboxApp('suguuqcyxtjo5qb','gmqiwhwcy65v5df','d8O1b7pcvqAAAAAAAAAABviuBjEYXLaV0gFUOWrBz4YkETT1tB_-wPzd3ohcH-Yr');
	$accountInfo = $dbxApp->getClientId();
	//echo "<pre>";print_r($accountInfo);

	$dbxClient = new dbx\Dropbox($dbxApp);
	if( $path != null )
	{
		$listFolderContents = $dbxClient->listFolder($path."/");
		$subitems 		    = $listFolderContents->getItems();
		return $subitems;
	}			
	else
		return array();
	
}
echo "<pre>";print_r($newItems);
die();

$items = $dbxClient->listFolder("/sarbrinder/");

echo "<br>**********"; echo "<pre>"; print_r($items); echo "</pre>"; //die;

//Fetch Cusrsor for listFolderContinue()
$cursor = $listFolderContents->getCursor();

//Paginate through the remaining items
$listFolderContinue = $dropbox->listFolderContinue($cursor);

$remainingItems = $listFolderContinue->getItems();

echo "<br>*******-****"; echo "<pre>"; print_r($remainingItems); echo "</pre>";


?>
