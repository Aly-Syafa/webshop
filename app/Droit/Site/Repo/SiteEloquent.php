<?php namespace App\Droit\Site\Repo;

use App\Droit\Site\Repo\SiteInterface;
use App\Droit\Site\Entities\Site as M;

class SiteEloquent implements SiteInterface{

    protected $site;

    public function __construct(M $site)
    {
        $this->site = $site;
    }

    public function getAll(){

        return $this->site->all();
    }

    public function find($id){

        return $this->site->find($id);
    }

    public function create(array $data){

        $site = $this->site->create(array(
            'nom'  => $data['nom'],
            'url'  => $data['url'],
            'logo' => $data['logo']
        ));

        if( ! $site )
        {
            return false;
        }

        return $site;
    }

    public function update(array $data){

        $site = $this->site->findOrFail($data['id']);

        if( ! $site )
        {
            return false;
        }

        $site->fill($data);
        $site->save();

        return $site;
    }

    public function delete($id){

        $site = $this->site->find($id);

        return $site->delete();

    }
}
