<form data-validate-parsley class="form add-bloc-form">

    <h4>Bloc lois</h4>

    <div class="form-group">
        <label for="contenu" class="control-label">Contenu</label>
        {!! Form::textarea('content', null, ['class' => 'form-control redactorBlocSimple'] ) !!}
    </div>

    <input name="type" value="loi" type="hidden">
    <input name="page_id" value="{{ $page_id }}" type="hidden">
    <button type="button" class="btn btn-success btn-sm add-bloc-btn">Ajouter</button>

</form>