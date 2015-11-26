<?php namespace App\Droit\Abo\Repo;

interface AboFactureInterface {

    public function getAll();
    public function find($data);
    public function create(array $data);
    public function update(array $data);
    public function delete($id);

}