<div class="line-spacer">
    <div class="row">
        <div class="col-md-4">
            <h4>Documents</h4>
            @if($group->doc_facture)
                <a target="_blank" href="{{ asset($group->doc_facture) }}{{ '?'.rand(0,1000) }}" class="btn btn-default btn-sm"><i class="fa fa-file"></i> &nbsp;Facture</a>
            @endif
            @if($group->doc_bv)
                <a target="_blank" href="{{ asset($group->doc_bv) }}{{ '?'.rand(0,1000) }}" class="btn btn-default btn-sm"><i class="fa fa-file"></i> &nbsp;BV</a>
            @endif
        </div>
        <div class="col-md-4">
            <h4>Date</h4>
            <p>{{ $group->inscriptions->first()->created_at->formatLocalized('%d %b %Y') }}</p>
        </div>
        <div class="col-md-4">
            @if($group->inscriptions->first()->send_at)
                <h4>Envoyé le </h4>
                <p><span class="fa fa-paper-plane"></span> &nbsp;{{ $group->inscriptions->first()->send_at->formatLocalized('%d %b %Y') }}</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="btn-group">
                <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#editGroup_{{ $group->id }}">Changer le détenteur</a>
                <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#addToGroup_{{ $group->id }}">Ajouter un participant</a>
                @if(!empty($group->colloque->annexe))
                    <a href="{{ url('admin/inscription/generate/'.$inscription->id) }}" class="btn btn-sm btn-warning">Regénérer les documents</a>
                @endif
            </div>
        </div>
        <div class="col-md-4 text-right">
            <button type="button" class="btn btn-sm btn-inverse" data-toggle="modal" data-target="#sendInscriptionGroup_{{ $group->id }}">Envoyer l'inscription</button>
        </div>
    </div>
</div>