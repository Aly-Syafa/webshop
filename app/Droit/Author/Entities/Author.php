<?php namespace App\Droit\Author\Entities;

use Illuminate\Database\Eloquent\Model;

class Author extends Model {

	protected $fillable = ['first_name','last_name','occupation','bio','photo','rang'];

    public $timestamps  = false;

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getNameTitleAttribute()
    {
        return $this->first_name.' '.$this->last_name.', '.$this->occupation;
    }

    public function getTitleAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getAuthorPhotoAttribute()
    {
        return (!empty($this->photo) ? $this->photo : 'avatar.jpg');
    }

    public function analyses()
    {
        return $this->belongsToMany('\App\Droit\Analyse\Entities\Analyse', 'analyse_authors', 'analyse_id', 'author_id');
    }

    public function products()
    {
        return $this->belongsToMany('\App\Droit\Shop\Product\Entities\Product', 'shop_product_authors', 'author_id', 'product_id');
    }

}

