<?php

namespace App\Http\Controllers\Admin\Colloque;

use Illuminate\Http\Request;
use App\Droit\Colloque\Repo\ColloqueInterface;
use App\Droit\Inscription\Repo\InscriptionInterface;
use App\Droit\Inscription\Worker\InscriptionWorker;
use App\Droit\User\Repo\UserInterface;
use App\Http\Requests;
use App\Http\Requests\InscriptionRequest;
use App\Http\Controllers\Controller;
use App\Events\InscriptionWasRegistered;
use App\Events\GroupeInscriptionWasRegistered;

class InscriptionController extends Controller
{
    protected $inscription;
    protected $register;
    protected $colloque;
    protected $user;
    protected $generator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ColloqueInterface $colloque, InscriptionInterface $inscription, UserInterface $user, InscriptionWorker $register)
    {
        $this->colloque    = $colloque;
        $this->inscription = $inscription;
        $this->register    = $register;
        $this->user        = $user;
        $this->generator   = new \App\Droit\Generate\Pdf\PdfGenerator();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $colloques = $this->colloque->getAll();

        return view('backend.inscriptions.index')->with(['colloques' => $colloques]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function colloque($id)
    {
        //$simple   = $this->inscription->getByColloque($id,'simple');
        //$multiple = $this->inscription->getByColloque($id,'multiple');

        $inscriptions = $this->inscription->getByColloque($id);

        if(!$inscriptions->isEmpty())
        {
            foreach($inscriptions as $inscription)
            {
                $groupe = ($inscription->group_id ? $inscription->group_id : 0);

                $user = $inscription->inscrit;
                $user->load('adresses');

                $inscription->setAttribute('adresse_facturation',$user->adresse_facturation);

                if($inscription->group_id)
                {
                    $inscription->load('groupe','participant');
                    $inscription->groupe->load('user');
                    $grouped[$groupe][] = $inscription;
                }
                else
                {
                    $grouped[] = $inscription;
                }
            }
        }

        return view('backend.inscriptions.index')->with(['inscriptions' => $grouped]);
    }

    /**
     * Display creation.
     *
     * @return Response
     */
    public function create()
    {
        $colloques = $this->colloque->getAll();
        $colloque = $this->colloque->find(71);

        return view('backend.inscriptions.create')->with(['colloques' => $colloques,'colloque' => $colloque]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(InscriptionRequest $request)
    {

        $type     = $request->input('type');
        $colloque = $this->colloque->find($request->input('colloque_id'));

        // if type simple
        if($type == 'simple')
        {
            $data        = $request->all();
            $inscription = $this->register->register($data,$colloque->id);
            $counter     = $colloque->counter + 1;

            event(new InscriptionWasRegistered($inscription));
        }
        else
        {
            // Create a new group holder
            $groupe = new \App\Droit\Inscription\Entities\Groupe();

            $group_user   = $groupe->create(['colloque_id' => $colloque->id , 'user_id' => $request->input('user_id')]);

            // Get all infos for inscriptions/participants
            $participants = $request->input('participant');
            $prices       = $request->input('price_id');
            $options      = $request->input('options');
            $groupes      = $request->input('groupes');

            foreach($participants as $index => $participant)
            {
                $data = [
                    'group_id'    => $group_user->id,
                    'colloque_id' => $colloque->id,
                    'participant' => $participant,
                    'price_id'    => $prices[$index]
                ];

                // choosen options for participants
                if(isset($options[$index]))
                {
                    $data['options'] = $options[$index];
                }

                // choosen groupe of options for participants
                if(isset($groupes[$index]))
                {
                    $data['groupes'] = $groupes[$index];
                }

                // Register a new inscription
                $inscriptions[] = $this->register->register($data,$colloque->id);

                // Update counter for no inscription
                $counter = $colloque->counter + 1;
            }
        }

        event(new GroupeInscriptionWasRegistered($group_user));

        // Update counter
        $colloque->counter = $counter;
        $colloque->save();

        return redirect('admin/inscription')->with(array('status' => 'success', 'message' => 'L\'inscription à bien été crée' ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $inscription = $this->inscription->find($id);

        return view('backend.inscriptions.show')->with(['inscription' => $inscription]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function generate($id)
    {
        $inscription = $this->inscription->find($id);
        $annexes     = $inscription->colloque->annexe;

        $this->generator->setInscription($inscription)->generate($annexes);

        return redirect('admin/inscription/'.$id)->with(array('status' => 'success', 'message' => 'Les documents ont été mis à jour' ));
    }

    /**
     * Send inscription via admin
     *
     * @param  int  $id
     * @return Response
     */
    public function send($id)
    {
        $inscription = $this->inscription->find($id);

        event(new InscriptionWasRegistered($inscription));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Inscription partial
     * @return Response
     */
    public function inscription(Request $request){

        $colloque = $this->colloque->find($request->input('colloque_id'));
        $user     = $this->user->find($request->input('user_id'));
        $type     = $request->input('type');

        echo view('backend.inscriptions.partials.'.$type)->with(['colloque' => $colloque, 'user_id' => $request->input('user_id'), 'user' => $user, 'type' => $type]);
    }

}
