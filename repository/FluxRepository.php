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

        return $status[0]['id'];
    }

    /**
     * @param $data Flux
     * @return string
     */
    public function insert($data)
    {
        if ($data instanceof Flux) {

            if ($data instanceof Flux) {
                $data = $this->fluxToArray($data);
            }
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

        $query = "select flux.id, flux.name, flux.description, flux.id_user_init, flux.id_role_current, flux.created_at, flux_status.name status from flux
                  left join flux_status on flux.id_status = flux_status.id" . $where;

        $flux = $this->dbService->select($query, $this->flowClassName, array_values($filter));

        if (count($flux) == 0) {
            throw new Exception("Flux not found");
        }

        return $flux;
    }

    public function update($where = array(), $data = array())
    {
        if ($data instanceof Flux) {
            $data = $this->fluxToArray($data);
        }

        $where_string = self::whereToString($where);
        $update = self::updateToString($data);

        $query = "update flux set " . $update . " " . $where_string;

        return $this->dbService->update($query, array_values($where));
    }

    public function delete($where = array())
    {
        if (empty($where)) {
            throw new Exception("Where clause empty, can't delete all users");
        }

        $where = self::whereToString($where);

        $query = "delete from flux " . $where;

        return $this->dbService->delete($query);
    }

    /**
     * @param $flux Flux
     * @return array
     */
    protected function fluxToArray($flux)
    {
        return array(
            'name' => $flux->getName(),
            'description' => $flux->getDescription(),
            'id_user_init' => $flux->getIdUserInit(),
            'id_role_current' => $flux->getIdRoleCurrent(),
            'created_at' => $flux->getCreatedAt(),
            'id_status' => $this->getFluxStatusId($flux->getStatus())
        );
    }

}