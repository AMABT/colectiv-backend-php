<?php
/**
 * Created by PhpStorm.
 * User: AlexandraTu
 * Date: 1/17/2017
 * Time: 9:23 PM
 */

include_once MODEL_FOLDER . 'Document.php';

class DocumentRepository extends AbstractRepository
{

    protected $dbService;
    protected $documentClassName = 'Document';

    public function __construct()
    {
        $this->dbService = DBService::getInstance();
    }

    /**
     * @param $userId integer
     * @return Document[]
     */
    public function getDocumentsByUser($userId)
    {
        return $this->get(array(
            'id_user' => $userId
        ));
    }

    /**
     * @param array $filter
     * @return Document[]
     * @throws Exception
     */
    public function get($filter = array())
    {
        $where = self::whereToString($filter);

        $query = "select * from documents " . $where;
        $documents = $this->dbService->select($query, $this->documentClassName, array_values($filter));

        if (count($documents) == 0) {
            throw new Exception("Document/documents not found");
        }

        return $documents;
    }

    /**
     * @param $fluxId integer
     * @return Document[]
     * @throws Exception documents.id, documents.id_user, documents.name, documents.location, documents.created_at
     */
    public function getDocumentsByFlux($fluxId)
    {
        $query = "select * from flux_documents join documents on flux_documents.id_document = documents.id where flux_documents.id_flux = ?";
        $documents = $this->dbService->select($query, $this->documentClassName, array($fluxId));

        if (count($documents) == 0) {
            throw new Exception("Document/documents not found");
        }

        return $documents;
    }

    public function update($where = array(), $data = array())
    {
        // TODO: Implement update() method.
    }

    public function delete($where = array())
    {
        if (empty($where)) {
            throw new Exception("Where clause empty, can't delete all users");
        }

        $where_string = self::whereToString($where);

        $query = "delete from documents " . $where_string;

        return $this->dbService->delete($query, array_values($where));
    }

    /**
     * @param Document $data
     */
    public function insert($data)
    {
        $data = array(
            'id_user' => $data->getIdUser(),
            'name' => $data->getName(),
            'location' => $data->getLocation(),
            'created_at' => $data->getCreatedAt()
        );

        $cols = implode(", ", array_keys($data));
        $values = array();
        foreach ($data as $v) {
            $values[] = '?';
        }
        $values = implode(', ', $values);

        $sql = "insert into documents ($cols) values ($values)";

        $this->dbService->insert($sql, array_values($data));
    }
}