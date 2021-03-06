<div class="panel panel-midnightblue">
    <div class="panel-heading">
        <h4><i class="fa fa-star"></i> &nbsp;{{ $title }}</h4>
    </div>
    <div class="panel-body">

        @if(!$product->$types->isEmpty())
            @foreach($product->$types as $type)
                <div style="min-height: 30px;">
                    <strong style="line-height: 30px;">{{ $type->title or $type->name }}</strong>
                    <form action="{{ url('admin/product/removeType/'.$product->id) }}" method="POST" class="pull-right">
                        {!! csrf_field() !!}
                        <input type="hidden" name="type_id" value="{{ $type->id }}" />
                        <input type="hidden" name="type" value="{{ $types }}" />
                        <button data-action="{{ $type->title }}" class="btn btn-danger btn-xs deleteAction">x</button>
                    </form>
                </div>
                <?php $choices[] = $type->id; ?>
            @endforeach
            <hr/>
        @endif

        <h4>Ajouter {{ $title }}</h4>
        <form action="{{ url('admin/product/addType/'.$product->id) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="type" value="{{ $types }}">
            <div class="form-group">
                @if(!$items->isEmpty())
                    <p><select class="form-control multi-selection" name="type_id[]" multiple>
                        <option value="">Choix</option>
                        @foreach($items as $item)
                            <option {{ isset($choices) && in_array($item->id, $choices) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->title or $item->name }}</option>
                        @endforeach
                    </select></p>
                    <button class="btn btn-info" type="submit">Ajouter</button>
                @endif
            </div>
        </form>
    </div>
</div>