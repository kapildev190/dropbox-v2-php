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

$dbxApp = new dbx\DropboxApp('3hwuscp97rpc6z7','9gug32qx51a2io1','_gaOMfYC23AAAAAAAAADPntwxxIbwHxBNOIbG2hr2F55eUZaD-vxgyLGVu2S0R5P');
$accountInfo = $dbxApp->getClientId();
echo "<pre>##############################################";print_r($accountInfo);

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

echo "<br>-----------"; echo "<pre>"; print_r($listFolderContents); echo "</pre>";


$items = $dbxClient->listFolder("/Standard VAT/");

echo "<br>**********"; echo "<pre>"; print_r($items); echo "</pre>"; //die;

$folderMetadata = $dbxClient->getMetadataWithChildren("/");
print_r($folderMetadata);

echo "<br>/////////"; echo "<pre>"; print_r($items); echo "</pre>"; //die;



//echo "<br>**********";
//$folderMetadata = $dbxClient->get('https://api.dropboxapi.com/2/files/list_revisions');
//print_r($folderMetadata);

die;


//If more items are available
if ($listFolderContents->hasMoreItems()) {
    //Fetch Cusrsor for listFolderContinue()
    $cursor = $listFolderContents->getCursor();

    //Paginate through the remaining items
    $listFolderContinue = $dropbox->listFolderContinue($cursor);

    $remainingItems = $listFolderContinue->getItems();

    echo "<br>**********"; echo "<pre>"; print_r($remainingItems); echo "</pre>";
}


?>