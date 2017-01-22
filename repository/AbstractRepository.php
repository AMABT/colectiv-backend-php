<?php

interface AbstractRepository
{
    public function create($data = array());

    public function get($filter = array());

    public function update($where = array(), $data = array());

    public function delete($where = array());

}