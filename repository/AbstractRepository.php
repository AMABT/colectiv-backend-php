<?php

abstract class AbstractRepository
{
    abstract public function insert($data = array());

    abstract public function get($filter = array());

    abstract public function update($where = array(), $data = array());

    abstract public function delete($where = array());

    /**
     *
     * @param $filter array
     * @return array|string
     */
    protected static function whereToString($filter)
    {
        if (!empty($filter)) {
            $where = [];
            foreach ($filter as $key => $val) {
                $where[] = $key . ' = ? ';
            }
            $where = ' where ' . implode(' and ', $where);
        } else {
            $where = '';
        }

        return $where;
    }

    /**
     *
     * @param $data array
     * @return array|string
     */
    protected static function updateToString($data)
    {
        if (!empty($data)) {
            $update = array();
            foreach ($data as $key => $val) {
                $update[] = "`$key` = '$val'";
            }
            $update = implode(", ", $update);
        } else {
            $update = '';
        }

        return $update;
    }

}