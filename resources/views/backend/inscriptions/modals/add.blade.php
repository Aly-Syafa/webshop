<!-- Modal -->
<div class="modal fade" id="addToGroup_{{ $group->id }}" tabindex="-1" role="dialog" aria-labelledby="editGroup">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- form start -->
            <form data-validate-parsley action="{{ url('admin/inscription/push') }}" method="POST" class="form" >
                {!! csrf_field() !!}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ajouter une Inscription au groupe</h4>
                </div>
                <div class="modal-body">

                    <h4>Détenteur: {!! $group->name !!}</h4>

                    <div class="form-group">
                        <label><strong>Colloque</strong></label>
                        <p>{{ $colloque->titre }}</p>
                        <input type="hidden" name="colloque_id" value="{{ $colloque->id }}" />
                    </div>

                    <div class="form-group">
                        <label>Nom du participant</label>
                        <input name="participant" required class="form-control" value="" type="text">
                    </div>

                    @if(!$colloque->prices->isEmpty())
                        @include('backend.inscriptions.partials.prices', ['select' => 'price_id'])
                    @endif

                    <!-- Occurence if any -->
                    @if(!$colloque->occurrences->isEmpty())
                        <h4>Conférences</h4>
                        @include('backend.inscriptions..partials.occurrences', ['select' => 'occurrences[]'])
                    @endif

                    @if(!$colloque->options->isEmpty())
                        <h4>Merci de préciser</h4>
                        @include('backend.inscriptions.partials.options', ['select' => 'groupes', 'add' => true])
                    @endif

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="group_id" value="{{ $group->id}}" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->