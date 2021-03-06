@extends('frontend.pubdroit.profil.index')
@section('profil')
    @parent

    <!-- start wrapper -->
    <div class="profil-wrapper">
        @if(isset($user->inscriptions) && !$user->inscriptions->isEmpty())

            <h3>{{ $inscription->colloque->titre }} <small>{{ $inscription->colloque->soustitre }}</small></h3>
            <p class="text-primary">{{ $inscription->colloque->location->name }}</p>
            <p>{{ $inscription->colloque->event_date }}</p>
            <hr/>

            <div class="row">
                <div class="col-md-6">
                    <h4>Date d'inscription</h4>
                    <div class="profil-info">
                        <p>{{ $inscription->created_at->formatLocalized('%d %B %Y') }}</p>
                    </div>
                    <h4>Infos</h4>
                    <div class="profil-info">
                        <p><strong>N°:</strong> {{ $inscription->inscription_no }}</p>
                        <p><strong>Prix:</strong>{{ $inscription->price_cents }}</p>
                    </div>
                    <h4>Payement</h4>
                    <div class="profil-info">
                        @if($inscription->payed_at)
                            <h5><i class="fa fa-check text-success"></i> &nbsp;Payé le {{ $inscription->payed_at->format('d/m/Y') }}</h5>
                        @else
                            <h5><i class="fa fa-times"></i> &nbsp;En attente</h5>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">

                    <h4>Documents</h4>
                    <div class="profil-info">

                        @if(!empty($inscription->documents))
                            @foreach($inscription->documents as $type => $annexe)
                                <?php
                                    $path = config('documents.colloque.'.$type.'');
                                    $file = 'files/colloques/'.$type.'/'.$annexe['name'];
                                    echo '<a target="_blank" href="'.asset($file).'" class="btn btn-primary btn-block" style="text-align:left;"><i class="fa fa-file"></i> &nbsp;'.ucfirst($type).'</a>';
                                ?>
                            @endforeach
                        @endif

                    </div>

                    <h4>Options</h4>
                    <div class="profil-info">
                        @if(!$inscription->user_options->isEmpty())
                            <ol>
                                @foreach($inscription->user_options as $user_options)

                                    <li>{{ $user_options->option->title }}

                                        @if($user_options->option->type == 'choix')
                                            <?php $user_options->load('option_groupe'); ?>
                                            <p class="text-info">{{ $user_options->option_groupe->text }}</p>
                                        @endif

                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
