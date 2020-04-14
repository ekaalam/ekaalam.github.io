<?php
trait DataTraits
{
    final public function updateData($data, $row_id)
    {
        $args = array(
            'where' => array(
                'id' => $row_id
            )
        );
        $status =  $this->update($data, $args);
        if ($status) {
            return $row_id;
        } else {
            return false;
        }
    }
    final public function insertData($data)
    {
        $insert_id = $this->insert($data);
        return $insert_id;
    }
    final public function getAllRows()
    {
        return $this->select();
    }
    final public function getRowById($id)
    {
        $args = array(
            'where' => array(
                'id' => $id
            )
        );
        return $this->select($args);
    }
    final public function deleteRowById($id)
    {
        $args = array(
            'where' => array(
                'id' => $id
            )
        );
        return $this->delete($args);
    }
}
