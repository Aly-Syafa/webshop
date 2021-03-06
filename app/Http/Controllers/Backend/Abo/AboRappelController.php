<?php namespace App\Http\Controllers\Backend\Abo;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\NotifyJobFinished;
use App\Jobs\MergeRappels;

use App\Droit\Generate\Pdf\PdfGeneratorInterface;
use App\Droit\Abo\Worker\AboWorkerInterface;
use App\Droit\Abo\Repo\AboInterface;
use App\Droit\Abo\Repo\AboRappelInterface;
use App\Droit\Abo\Repo\AboFactureInterface;
use App\Droit\Shop\Product\Repo\ProductInterface;

class AboRappelController extends Controller {

    protected $abo;
    protected $rappel;
    protected $facture;
    protected $product;
    protected $generator;
    protected $worker;

    public function __construct(AboInterface $abo, AboRappelInterface $rappel, AboFactureInterface $facture, ProductInterface $product, PdfGeneratorInterface $generator, AboWorkerInterface $worker)
    {
        $this->abo       = $abo;
        $this->rappel    = $rappel;
        $this->facture   = $facture;
        $this->product   = $product;
        $this->generator = $generator;
        $this->worker    = $worker;

        setlocale(LC_ALL, 'fr_FR.UTF-8');
	}

	public function store(Request $request)
	{
        $rappel  = $this->rappel->create($request->all());
        $rappel->load('facture');

        $rappels = $this->rappel->findByAllFacture($request->abo_facture_id);
        $rappels = $rappels->count();

        $this->generator->makeAbo('rappel', $rappel->facture, $rappels, $rappel);

        return redirect()->back()->with(array('status' => 'success', 'message' => 'La rappel a été crée' ));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rappel = $this->rappel->update($request->all());

        return redirect('admin/abo/'.$rappel->id)->with(array('status' => 'success', 'message' => 'La rappel a été mis à jour' ));
    }


	public function destroy($id, Request $request)
	{
        $this->rappel->delete($id);

        return redirect()->back()->with(array('status' => 'success', 'message' => 'Le rappel a été supprimé' ));
	}

    /*
    * Generate all invoices and bind the all
    * */
    public function generate($product_id)
    {
        $abo = $this->abo->findAboByProduct($product_id);

        $this->worker->rappels($product_id, $abo->id);

        return redirect()->back()->with(['status' => 'success', 'message' => 'La création des rappels est en cours.<br/>Un email vous sera envoyé dès que la génération des rappels sera terminée.']);
    }

    /*
    * Generate all invoices
    * */
    public function bind($product_id)
    {
        $abo     = $this->abo->findAboByProduct($product_id);
        $product = $this->product->find($product_id);

        // Name of the pdf file with all the invoices bound together for a particular edition
        $name = 'rappels_'.$product->reference.'_'.$product->edition;

        // Job for merging documents
        $merge = (new MergeRappels($product->id, $name, $abo->id));
        $this->dispatch($merge);

        $job = (new NotifyJobFinished('Les rappels ont été attachés. Nom du fichier: <strong>'.$name.'</strong>'));
        $this->dispatch($job);

        return redirect()->back()->with(['status' => 'success', 'message' => 'Les rappels dont re-attachés.<br/>Rafraichissez la page pour mettre à jour le document.']);
    }
}