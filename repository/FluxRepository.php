<?php

include_once MODEL_FOLDER . 'Flux.php';

class FluxRepository extends AbstractRepository
{

    protected $dbService;
    protected $flowClassName = 'Flux';

    public function __construct()
    {
        $this->dbService = DBService::getInstance();
    }

    /**
     * @return Flux[]
     * @throws Exception
     */
    public function getActiveFlux()
    {
        return $this->get(array(
            'flux_status.name' => FluxStatus::Pending
        ));
    }

    /**
     * @return Flux[]
     * @throws Exception
     */
    public function getInactiveFlux()
    {
        return $this->get(array(
            'flux_status.name' => FluxStatus::Rejected
        ));
    }

    /**
     * @param $userId
     * @return Flux[]
     */
    public function getUserFlux($userId)
    {
        return $this->get(array(
            'flux.id_user_init' => $userId
        ));
    }

    /**
     * @param $userId
     * @return Flux[]
     */
    public function getUserWaitingFlux($userId)
    {
        return $this->get(array(
            'flux.id_user_current' => $userId
        ));
    }

    /**
     * @param $name
     * @return integer
     * @throws Exception
     */
    public function getFluxStatusId($name)
    {
        $query = "select * from flux_status where name = ?";

        $status = $this->dbService->select($query, null, array($name));

        if (count($status) == 0) {
            throw new Exception("Flux status not found");
        }

        return $status['id'];
    }

    /**
     * @param $data Flux
     * @return string
     */
    public function insert($data)
    {
        if ($data instanceof Flux) {

            $data = array(
                'name' => $data->getName(),
                'description' => $data->getDescription(),
                'id_user_init' => $data->getIdUserInit(),
                'id_role_current' => $data->getIdRoleCurrent(),
                'created_at' => $data->getCreatedAt(),
                'id_status' => $this->getFluxStatusId($data->getStatus())
            );
        }

        $cols = implode(", ", array_keys($data));
        $values = array();
        foreach ($data as $v) {
            $values[] = '?';
        }
        $values = implode(', ', $values);

        $sql = "insert into flux ($cols) values ($values)";

        return $this->dbService->insert($sql, array_values($data));
    }

    /**
     * @param $fluxId integer
     * @param $documentId integer
     * @return string
     */
    public function addDocumentToFlux($fluxId, $documentId)
    {
        $query = "insert into flux_documents (`id_flux`, `id_document`) values (?, ?)";

        return $this->dbService->insert($query, array($fluxId, $documentId));
    }

    /**
     * @param array $filter
     * @return Flux[]
     * @throws Exception
     */
    public function get($filter = array())
    {
        $where = self::whereToString($filter);

        $query = "select flux.name, flux.description, flux.id_user_init, flux.id_user_current, flux.created_at, flux_status.name status from flux
                  left join flux_status on flux.id_status = flux_status.id" . $where;

        $flux = $this->dbService->select($query, $this->flowClassName, array_values($filter));

        if (count($flux) == 0) {
            throw new Exception("Flux not found");
        }

        return $flux;
    }

    public function update($where = array(), $data = array())
    {
        // TODO: Implement update() method.
    }

    public function delete($where = array())
    {
        // TODO: Implement delete() method.
    }
}