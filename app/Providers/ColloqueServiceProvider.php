<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ColloqueServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{

        $this->registerColloqueService();
        $this->registerLocationService();
        $this->registerOrganisateurService();
        $this->registerCompteService();
        $this->registerAttestationService();
        $this->registerInscriptionService();
        $this->registerInscriptionWorkerService();
        $this->registerRappelService();
        $this->registerDocumentService();
        $this->registerGroupeService();
        $this->registerOptionService();
        $this->registerGroupOptionService();
        $this->registerPriceService();
        $this->registerOccurrenceService();

	}

    /**
     * Colloque
     */
    protected function registerColloqueService(){

        $this->app->singleton('App\Droit\Colloque\Repo\ColloqueInterface', function()
        {
            return new \App\Droit\Colloque\Repo\ColloqueEloquent(new \App\Droit\Colloque\Entities\Colloque);
        });
    }

    /**
     * Inscription
     */
    protected function registerInscriptionService(){

        $this->app->singleton('App\Droit\Inscription\Repo\InscriptionInterface', function()
        {
            return new \App\Droit\Inscription\Repo\InscriptionEloquent(new \App\Droit\Inscription\Entities\Inscription);
        });
    }

    /**
     * Inscription
     */
    protected function registerInscriptionWorkerService(){

        $this->app->singleton('App\Droit\Inscription\Worker\InscriptionWorkerInterface', function()
        {
            return new \App\Droit\Inscription\Worker\InscriptionWorker(
                \App::make('App\Droit\Inscription\Repo\InscriptionInterface'),
                \App::make('App\Droit\Colloque\Repo\ColloqueInterface'),
                \App::make('App\Droit\Adresse\Repo\AdresseInterface'),
                \App::make('App\Droit\Option\Repo\OptionInterface'),
                \App::make('App\Droit\Inscription\Repo\GroupeInterface')
            );
        });
    }

    /**
     * Rappel
     */
    protected function registerRappelService(){

        $this->app->singleton('App\Droit\Inscription\Repo\RappelInterface', function()
        {
            return new \App\Droit\Inscription\Repo\RappelEloquent(new \App\Droit\Inscription\Entities\Rappel);
        });
    }

    /**
     * Document
     */
    protected function registerDocumentService(){

        $this->app->singleton('App\Droit\Document\Repo\DocumentInterface', function()
        {
            return new \App\Droit\Document\Repo\DocumentEloquent(new \App\Droit\Document\Entities\Document);
        });
    }

    /**
     * Groupe
     */
    protected function registerGroupeService(){

        $this->app->singleton('App\Droit\Inscription\Repo\GroupeInterface', function()
        {
            return new \App\Droit\Inscription\Repo\GroupeEloquent(new \App\Droit\Inscription\Entities\Groupe);
        });
    }

    /**
     * Location
     */
    protected function registerLocationService(){

        $this->app->singleton('App\Droit\Location\Repo\LocationInterface', function()
        {
            return new \App\Droit\Location\Repo\LocationEloquent(new \App\Droit\Location\Entities\Location);
        });
    }

    /**
     * Organisateur
     */
    protected function registerOrganisateurService(){

        $this->app->singleton('App\Droit\Organisateur\Repo\OrganisateurInterface', function()
        {
            return new \App\Droit\Organisateur\Repo\OrganisateurEloquent(new \App\Droit\Organisateur\Entities\Organisateur);
        });
    }

    /**
     * Compte
     */
    protected function registerCompteService(){

        $this->app->singleton('App\Droit\Compte\Repo\CompteInterface', function()
        {
            return new \App\Droit\Compte\Repo\CompteEloquent(new \App\Droit\Compte\Entities\Compte);
        });
    }

    /**
     * Attestation
     *
     */
    protected function registerAttestationService(){

        $this->app->singleton('App\Droit\Colloque\Repo\AttestationInterface', function()
        {
            return new \App\Droit\Colloque\Repo\AttestationEloquent(new \App\Droit\Colloque\Entities\Colloque_attestation());
        });
    }

    /**
     * Price
     */
    protected function registerPriceService(){

        $this->app->singleton('App\Droit\Price\Repo\PriceInterface', function()
        {
            return new \App\Droit\Price\Repo\PriceEloquent(new \App\Droit\Price\Entities\Price);
        });
    }

    /**
     * Option
     */
    protected function registerOptionService(){

        $this->app->singleton('App\Droit\Option\Repo\OptionInterface', function()
        {
            return new \App\Droit\Option\Repo\OptionEloquent(new \App\Droit\Option\Entities\Option);
        });
    }

    /**
     * GroupOption
     */
    protected function registerGroupOptionService(){

        $this->app->singleton('App\Droit\Option\Repo\GroupOptionInterface', function()
        {
            return new \App\Droit\Option\Repo\GroupOptionEloquent(new \App\Droit\Option\Entities\OptionGroupe());
        });
    }

    /**
     * Occurrence
     */
    protected function registerOccurrenceService(){

        $this->app->singleton('App\Droit\Occurrence\Repo\OccurrenceInterface', function()
        {
            return new \App\Droit\Occurrence\Repo\OccurrenceEloquent(new \App\Droit\Occurrence\Entities\Occurrence());
        });
    }

}
