<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Droit\Arret\Repo\ArretInterface;
use App\Droit\Categorie\Repo\CategorieInterface;
use App\Droit\Analyse\Repo\AnalyseInterface;
use App\Droit\Author\Repo\AuthorInterface;

use App\Droit\Page\Repo\PageInterface;
use App\Droit\Arret\Worker\JurisprudenceWorker;


class BailController extends Controller
{
    protected $arret;
    protected $categorie;
    protected $analyse;
    protected $author;
    protected $jurisprudence;
    protected $site;

    public function __construct(ArretInterface $arret, CategorieInterface $categorie, AnalyseInterface $analyse, AuthorInterface $author, JurisprudenceWorker $jurisprudence, PageInterface $page)
    {
        $this->site  = 2;

        $this->arret     = $arret;
        $this->categorie = $categorie;
        $this->analyse   = $analyse;
        $this->author    = $author;
        $this->page      = $page;

         $years = $this->arret->annees(2);

        view()->share('years',$years);

        setlocale(LC_ALL, 'fr_FR');
    }

    public function index()
    {
        $categories = $this->categorie->getAll($this->site);
        $authors    = $this->author->getAll();
        $page       = $this->page->getBySlug(2,'home');

        return view('frontend.bail.index')->with([ 'categories' => $categories , 'authors' => $authors, 'page' => $page ]);
    }

    public function lois(){

        return view('frontend.bail.lois');
    }

    public function autorites(){

        return view('frontend.bail.autorites');
    }

    public function jurisprudence()
    {
        $arrets     = $this->arret->getAll($this->site);
        $categories = $this->categorie->getAll($this->site);
        $analyses   = $this->analyse->getAll($this->site);
        $authors    = $this->author->getAll();

        $arrets     = $this->jurisprudence->preparedArrets($arrets);
        $analyses   = $this->jurisprudence->preparedAnalyses($analyses);

        return view('frontend.bail.jurisprudence')->with(['arrets' => $arrets , 'analyses' => $analyses, 'categories' => $categories, 'authors' => $authors ]);
    }

/*    public function doctrine(){

        $subjects   = $this->subject->getAll();
        $categories = $this->subject->arrangeCategories($subjects);
        $seminaires = $this->seminaire->getAll();

        return view('bail.doctrine')->with( array( 'seminaires' => $seminaires , 'subjects' => $subjects  ,'categories' => $categories ));
    }

    public function search(){

        $query = Request::get('q');

        $resultats = array();

        return view('bail.search')->with( array( 'resultats' => $query ));
    }

    public function calcul(){

        return view('bail.calcul')->with( array( ));
    }

    public function loyer(){

        $calcul = array();
        $data   = Input::all();

        if(!empty( $data ))
        {
            $canton = Input::get('canton');
            $date   = strtotime(Input::get('date'));
            $loyer  = Input::get('loyer');

            $calcul = $this->calculette->calculer($canton, $date , $loyer);
        }

        return $calcul;
    }*/


}
