<?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>

<div class="row">
    <div class="col-md-5 colloque-details">

        <p><strong>Lieu:</strong></p>
        <p>{{ $colloque->location ? $colloque->location->name : '' }}, {{ $colloque->location ? $colloque->location->adresse : '' }}</p>

        <p><strong>Date:</strong></p>
        <p>{{ $colloque->event_date }}</p>

        <p><strong>Délai d'inscription:</strong></p>
        <p>{{ $colloque->registration_at->formatLocalized('%d %B %Y') }}</p>

        <p><strong>Prix d'inscription:</strong></p>

        <?php $prices = $colloque->prices->whereLoose('type','public'); ?>
        @if(!$prices->isEmpty())
            <dl>
                @foreach($prices as $price)
                    <dt>{{ $price->description }}</dt>
                    <dd>{{ $price->price_cents }} CHF</dd>
                @endforeach
            </dl>
        @endif

    </div>
    <div class="col-md-3">
        @if(!$colloque->documents->isEmpty())
            @foreach($colloque->documents as $document)

                <?php $file = 'files/colloques/'.$document->type.'/'.$document->path; ?>
                @if (File::exists($file) && ($document->type == 'programme' || $document->type == 'document'))
                    <p><a class="btn btn-info btn-sm" href="{{ $file }}">{{ !empty($document->titre) ? $document->titre : 'Programme' }}</a></p>
                @endif

            @endforeach
        @endif

        @if($colloque->location && $colloque->location->location_map)
            <p><a class="btn btn-warning btn-sm" href="{{ $colloque->location->location_map }}">Plan d'accès</a></p>
        @endif
    </div>
    <div class="col-md-4">
        <img width="200px" src="{{ asset('files/colloques/illustration/'.$colloque->illustration->path) }}" />
    </div>
</div>