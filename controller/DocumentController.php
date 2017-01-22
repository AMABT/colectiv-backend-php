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

                $location = $this->user->getId() . '-' . (time() % 1000) . '-' . $name;

                if (!copy($tmp_name, $uploads_dir . $location)) {

                    return $this->errorResponse(array(
                        'status' => 'file not uploaded'
                    ));
                }

                $this->docRepo->insert(array(
                    'id_user' => $this->user->getId(),
                    'name' => $name,
                    'location' => $location,
                    'created_at' => date("Y-m-d H:i:s")
                ));

                // LogService::info('Upload complete ' . $name . ' ' . $location);

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

    public function getAllAction()
    {
        $result = array();

        try {

            $documents = $this->docRepo->getDocumentsByUser($this->user->getId());

            foreach ($documents as $doc) {
                $result[] = $doc->toArray();
            }

        } catch (Exception $e) {
            // pass
        }

        return $this->response($result);
    }

    public function deleteAction($documentId)
    {
        try {
            $document = $this->docRepo->get(array(
                'id' => $documentId
            ))[0];

            // delete from disk
            unlink(DOCUMENTS_FOLDER . $document->getLocation());

            // delete from db
            $this->docRepo->delete(array(
                'id' => $document->getId()
            ));

            return $this->response(array(
                'status' => 'success'
            ));

        } catch (Exception $e) {

            return $this->errorResponse('Document not found');
        }
    }

    public function downloadAction($documentId)
    {
        $document = $this->docRepo->get(array(
            'id' => $documentId
        ))[0];

        $file_url = DOCUMENTS_FOLDER . $document->getLocation();

        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($document->getName()) . "\"");
        readfile($file_url);
    }
}