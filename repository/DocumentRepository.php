<?php
/**
 * Created by PhpStorm.
 * User: AlexandraTu
 * Date: 1/17/2017
 * Time: 9:23 PM
 */

include_once MODEL_FOLDER . 'Document.php';

class DocumentRepository
{

    protected $dbService;
    protected $documentClassName = 'Document';

    public function __construct()
    {
        $this->dbService = DBService::getInstance();
    }

    /**
     * @return Document[]
     */
    public function getDocuments()
    {

        return $this->dbService->select("select * from documents", $this->userClassName);
    }

    /**
     * @param $user
     * @return Document[]
     * @throws Exception
     */
    public function getDocumentsByUser($user)
    {
        $user = $user;


        $documents = $this->dbService->select("select * from documents where p_user = ?", $this->documentClassName, array($user));

        if (count($documents) == 0) {
            throw new Exception("Documents not found");
        }

        return $documents;
    }


}