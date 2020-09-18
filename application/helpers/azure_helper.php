<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//require_once '../../vendor/autoload.php';
require __DIR__ . '/../../vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

function get_container_name(){
    return "skillcentral";
}

function get_azure_account_name(){
    return "cilappstorageaccount";
}

function get_azure_account_key(){
    return "icejvXX2h8y2skvKZ+bF1D9SW5ZJR2cX+e6UO6URXfb05RH8gkwMSjYn+WpNNFkOejqOEhMf3nV0z1gqbUnNFQ==";
}

function get_blob_client()
{
    
    $connectionString = "DefaultEndpointsProtocol=https;AccountName=" . get_azure_account_name()  . ";AccountKey=" . get_azure_account_key();

    // Create blob client.
    $blobClient = BlobRestProxy::createBlobService($connectionString);

    //log_message('info', '$blobClient: ' . $blobClient);

    return $blobClient;

    //require_once ('Microsoft/AutoLoader.php');        
    //$this->CI =& get_instance();

    //return new Microsoft_WindowsAzure_Storage_Blob(
     //   $this->CI->config->item('azure_blob_host'), 
     //   $this->CI->config->item('azure_storage_account_name'),
     //   $this->CI->config->item('azure_storage_account_key')
    //	false, 
    //	Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract::retryN(10, 250)
    //);
}

function delete_container()
{
    try {
        // Delete container.
        echo "Deleting Container" . PHP_EOL;

        $blobClient = get_blob_client();

        $blobClient->deleteContainer(get_container_name());
    } catch (ServiceException $e) {
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code . ": " . $error_message . "<br />";
    }
}

function list_all_blobs()
{
    $blobClient = get_blob_client();

    // List blobs.
    echo "These are the blobs present in the container: ";

    do {
        $result = $blobClient->listBlobs(get_container_name());
        foreach ($result->getBlobs() as $blob) {
            echo $blob->getName() . ": " . $blob->getUrl() . "<br />";
        }

        //$listBlobsOptions->setContinuationToken($result->getContinuationToken());
    } while ($result->getContinuationToken());
}

function get_blob($fileName)
{
    $blobClient = get_blob_client();

    // Get blob.
    echo "This is the content of the blob uploaded: ";
    $blob = $blobClient->getBlob(get_container_name(), $fileName);
    fpassthru($blob->getContentStream());
}

function upload_video_to_azure($fileToUpload, $filePath)
{
    

    try {
        $blobClient = get_blob_client();

        // Create container.
        //$blobClient->createContainer($containerName);

        // Getting local file so that we can upload it to Azure
       // $myfile = fopen($fileToUpload, "w") or die("Unable to open file!");
       // fclose($myfile);

        # Upload file as a block blob
        log_message('info', 'Uploading BlockBlob: ' . PHP_EOL);

        log_message('info', '$fileToUpload: ' . $fileToUpload);
        log_message('info', '$filePath: ' . $filePath);
      
        $content = fopen($filePath, "r");

        log_message('info', '$content: ' . $content);

        //Upload blob
        $blobClient->createBlockBlob(get_container_name(), $filePath, $content);

    } catch (ServiceException $e) {
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code . ": " . $error_message . "<br />";
        log_message('info', 'Error: ' . $code . ": " . $error_message );
    }   
}