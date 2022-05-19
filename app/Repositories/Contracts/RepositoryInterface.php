<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface {
 
    public function all($columns = array('*'));
 
    public function paginate($perPage = 15, $columns = array('*'));
 
    public function create(array $data);
 
    public function update(array $data, $id);
 
    public function delete($id);
 
    public function find($id, $columns = array('*'));
 
    public function findBy($field, $value, $columns = array('*'));

    public function first($columns = array('*'));

    public function where(array $fields, $columns = array('*'));

    public function whereIn(array $fields, $columns = array('*'));

    public function whereNotIn(array $fields, $columns = array('*'));

    public function UploadFile(array $data, $id);
    public function deleteFile($id);


}