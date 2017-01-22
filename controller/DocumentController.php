<?php

include_once REPOSITORY_FOLDER . 'DocumentRepository.php';

class DocumentController extends BaseController
{

    protected $docRepo;

    public function __construct()
    {
        $this->docRepo = new DocumentRepository();
    }

    public function testuploadAction()
    {
        $uploads_dir = DOCUMENTS_FOLDER;

        $tmp_name = APP_FOLDER . 'Archive.zip';
        $name = 'Archive.zip';

        echo '<pre>';
        var_dump($tmp_name);
        var_dump($uploads_dir . $name);

        if (copy($tmp_name, $uploads_dir . $name)) {
            echo 'success';
        } else {
            echo 'fail';
        }
    }

    public function uploadAction()
    {
        $uploads_dir = DOCUMENTS_FOLDER;

        if (!empty($_FILES["file"])) {

            if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {

                $tmp_name = $_FILES["file"]["tmp_name"];
                $name = $_FILES["file"]["name"];

                if (!copy($tmp_name, $uploads_dir . $name)) {
                    //LogService::info('Upload complete ' . $name . ' ' . "$uploads_dir$name");
                    return $this->errorResponse(array(
                        'status' => 'file not uploaded'
                    ));
                }

                return $this->response(array(
                    'status' => 'ok'
                ));

            } else {

                //LogService::error('File upload error');
                return $this->errorResponse(array(
                    'status' => 'file not uploaded'
                ));
            }
        }

        //LogService::error('No file for upload');
        return $this->errorResponse(array(
            'status' => 'no file sent'
        ));

    }
}