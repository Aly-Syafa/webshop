<?php namespace App\Droit\Newsletter\Repo;

interface NewsletterCampagneInterface {

	public function getAll();
    public function getAllSent();
	public function getNotSent();
    public function getLastCampagne();
	public function find($data);
	public function create(array $data);
	public function update(array $data);
    public function updateStatus($data);
	public function delete($id);

}
