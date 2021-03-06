<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ContentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAuthorService();
        $this->registerArretService();
        $this->registerAnalyseService();
        $this->registerCategorieService();
        $this->registerGroupeService();
        $this->registerUploadService();
        $this->registerContentService();
        $this->registerBlocService();
    }

    /**
     * Author
     */
    protected function registerAuthorService(){

        $this->app->singleton('App\Droit\Author\Repo\AuthorInterface', function()
        {
            return new \App\Droit\Author\Repo\AuthorEloquent( new \App\Droit\Author\Entities\Author );
        });
    }

    /**
     * Analyse
     */
    protected function registerAnalyseService(){

        $this->app->singleton('App\Droit\Analyse\Repo\AnalyseInterface', function()
        {
            return new \App\Droit\Analyse\Repo\AnalyseEloquent( new \App\Droit\Analyse\Entities\Analyse );
        });
    }

    /**
     * Arret
     */
    protected function registerArretService(){

        $this->app->singleton('App\Droit\Arret\Repo\ArretInterface', function()
        {
            return new \App\Droit\Arret\Repo\ArretEloquent( new \App\Droit\Arret\Entities\Arret );
        });
    }

    /**
     * Categorie
     */
    protected function registerCategorieService(){

        $this->app->singleton('App\Droit\Categorie\Repo\CategorieInterface', function()
        {
            return new \App\Droit\Categorie\Repo\CategorieEloquent( new \App\Droit\Categorie\Entities\Categorie );
        });
    }


    /**
     * Groupe
     */
    protected function registerGroupeService(){

        $this->app->singleton('App\Droit\Arret\Repo\GroupeInterface', function()
        {
            return new \App\Droit\Arret\Repo\GroupeEloquent( new \App\Droit\Arret\Entities\Groupe );
        });
    }

    /**
     * Upload service
     */
    protected function registerUploadService(){

        $this->app->singleton('App\Droit\Service\UploadInterface', function()
        {
            return new \App\Droit\Service\UploadWorker();
        });
    }

    /**
     * Content service
     */
    protected function registerContentService(){

        $this->app->singleton('App\Droit\Content\Repo\ContentInterface', function()
        {
            return new \App\Droit\Content\Repo\ContentEloquent( new \App\Droit\Content\Entities\Content );
        });
    }

    /**
     * Bloc service
     */
    protected function registerBlocService(){

        $this->app->singleton('App\Droit\Bloc\Repo\BlocInterface', function()
        {
            return new \App\Droit\Bloc\Repo\BlocEloquent( new \App\Droit\Bloc\Entities\Bloc );
        });
    }

}
