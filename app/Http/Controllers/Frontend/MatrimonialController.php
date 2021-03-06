<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Droit\Arret\Repo\ArretInterface;
use App\Droit\Categorie\Repo\CategorieInterface;
use App\Droit\Analyse\Repo\AnalyseInterface;
use App\Droit\Author\Repo\AuthorInterface;

use App\Droit\Page\Repo\PageInterface;
use App\Droit\Site\Repo\SiteInterface;
use App\Droit\Arret\Worker\JurisprudenceWorker;

use App\Droit\Newsletter\Repo\NewsletterInterface;
use App\Droit\Newsletter\Repo\NewsletterCampagneInterface;
use App\Droit\Newsletter\Worker\CampagneInterface;

class MatrimonialController extends Controller
{
    protected $arret;
    protected $categorie;
    protected $analyse;
    protected $author;
    protected $jurisprudence;
    protected $site_id;
    protected $site;

    protected $newsletter;
    protected $campagne;
    protected $worker;

    public function __construct(
        ArretInterface $arret,
        CategorieInterface $categorie,
        AnalyseInterface $analyse,
        AuthorInterface $author,
        JurisprudenceWorker $jurisprudence,
        PageInterface $page,
        SiteInterface $site,
        NewsletterInterface $newsletter,
        NewsletterCampagneInterface $campagne,
        CampagneInterface $worker
    )
    {
        $this->site_id  = 3;

        $this->arret         = $arret;
        $this->categorie     = $categorie;
        $this->analyse       = $analyse;
        $this->author        = $author;
        $this->page          = $page;
        $this->jurisprudence = $jurisprudence;
        $this->site          = $site;

        $years      = $this->arret->annees(3);
        $categories = $this->categorie->getAll($this->site_id);
        $authors    = $this->author->getAll();

        $sites = $this->site->find(3);

        $this->campagne   = $campagne;
        $this->worker     = $worker;
        $this->newsletter = $newsletter;

        $newsletters = $this->newsletter->getAll(3);

        view()->share('newsletters',$newsletters->first()->campagnes->pluck('sujet','id') );
        view()->share('menus',$sites->menus);
        view()->share('site',$sites);
        view()->share('years',$years);
        view()->share('categories',$categories);
        view()->share('authors',$authors);

        setlocale(LC_ALL, 'fr_FR');
    }

    public function index()
    {
        $page = $this->page->getBySlug(3,'home');

        return view('frontend.matrimonial.index')->with([ 'page' => $page ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return Response
     */
    public function page($slug,$var = null)
    {
        $page = $this->page->getBySlug($this->site_id,$slug);

        $data['page'] = $page;

        if($slug == 'jurisprudence')
        {
            $arrets     = $this->arret->getAll($this->site_id)->take(10);
            $analyses   = $this->analyse->getAll($this->site_id)->take(10);

            $data['arrets']   = $this->jurisprudence->preparedArrets($arrets);
            $data['analyses'] = $this->jurisprudence->preparedAnalyses($analyses);
        }

        if($slug == 'newsletter')
        {
            if($var)
            {
                $data['campagne'] = $this->campagne->find($var);
                $data['content']  = $this->worker->prepareCampagne($var);
            }
            else
            {
                $newsletters = $this->newsletter->getAll($this->site_id)->first();
                if(!$newsletters->campagnes->isEmpty())
                {
                    $data['campagne'] = $newsletters->campagnes->first();
                    $data['content']  = $this->worker->prepareCampagne($newsletters->campagnes->first()->id);
                }
            }

            $data['categories']    = $this->worker->getCategoriesArrets();
            $data['imgcategories'] = $this->worker->getCategoriesImagesArrets();

        }

        return view('frontend.matrimonial.'.$page->template)->with($data);
    }

    public function jurisprudence()
    {
        $arrets     = $this->arret->getAll($this->site_id)->take(10);
        $analyses   = $this->analyse->getAll($this->site_id)->take(10);

        $arrets     = $this->jurisprudence->preparedArrets($arrets);
        $analyses   = $this->jurisprudence->preparedAnalyses($analyses);

        return view('frontend.matrimonial.jurisprudence')->with(['arrets' => $arrets , 'analyses' => $analyses]);
    }

    public function newsletters($id = null)
    {
        if($id)
        {
            $campagne = $this->campagne->find($id);
            $content  = $this->worker->prepareCampagne($id);
        }
        else
        {

        }

        $categories    = $this->worker->getCategoriesArrets();
        $imgcategories = $this->worker->getCategoriesImagesArrets();

        return view('frontend.matrimonial.newsletter')->with(['arrets' => $arrets , 'analyses' => $analyses]);
    }
}
