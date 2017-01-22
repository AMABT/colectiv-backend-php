<?php

include_once REPOSITORY_FOLDER . 'DocumentRepository.php';

class DocumentController extends BaseController
{

    protected $docRepo;

    public function __construct()
    {
        $this->docRepo = new DocumentRepository();
    }

    public function uploadAction()
    {
        $uploads_dir = DOCUMENTS_FOLDER;

        if (!empty($_FILES["file"])) {
            if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["file"]["tmp_name"];
                $name = $_FILES["file"]["name"];
                move_uploaded_file($tmp_name, "$uploads_dir/$name");

                return $this->response(array(
                    'status' => 'ok'
                ));
            }
        } else {
            return $this->errorResponse(array(
                'status' => 'no file sent'
            ));
        }

        return $this->errorResponse(array(
            'status' => 'file not uploaded'
        ));

    }
}