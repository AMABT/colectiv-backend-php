<?php

include_once MODEL_FOLDER . 'Flow.php';

class FlowRepository extends AbstractRepository
{

    protected $dbService;
    protected $flowClassName = 'Flow';

    public function __construct()
    {
        $this->dbService = DBService::getInstance();
    }

    /**
     * @return Flow[]
     */
    public function getActiveFlows()
    {

        return $this->dbService->select("select * from flows where status = 1", $this->flowClassName);
    }

    /**
     * @return Flow[]
     * @throws Exception
     */
    public function getInactiveFlows(){


        $flows =  $this->dbService->select("select * from flows where status = 0", $this->flowClassName);

        if (count($flows) == 0) {
            throw new Exception("Flows not found");
        }

        return $flows;
    }

    public function getUserFlow($userId) {

        $flows = $this->dbService->select("select * from flows where p_user = ?", $this->flowClassName, array($userId));

        if (count($flows) == 0) {
            throw new Exception("Flows not found");
        }

        return $flows;
    }


    public function insert($data = array())
    {
        // TODO: Implement insert() method.
    }

    public function get($filter = array())
    {
        // TODO: Implement get() method.
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