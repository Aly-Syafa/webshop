@extends('backend.layouts.master')
@section('content')

<div class="row"><!-- row -->
    <div class="col-md-12"><!-- col -->
        <p><a class="btn btn-default" href="{{ url('admin/menu') }}"><i class="fa fa-reply"></i> &nbsp;Retour à la liste</a></p>
    </div>
</div>
<!-- start row -->
<div class="row">

    @if ($menu)

    <div class="col-md-12">
        <div class="panel panel-midnightblue">

            <!-- form start -->
            <form action="{{ url('admin/menu/'.$menu->id) }}" method="POST" class="validate-form form-horizontal" data-validate="parsley">
                <input type="hidden" name="_method" value="PUT">
                {!! csrf_field() !!}

            <div class="panel-heading">
                <h4>&Eacute;diter {{ $menu->titre }}</h4>
            </div>
            <div class="panel-body event-info">

                <div class="form-group">
                    <label for="message" class="col-sm-3 control-label">Rang</label>
                    <div class="col-sm-2">
                        {!! Form::text('rang', $menu->rang , ['class' => 'form-control'] ) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="type" class="col-sm-3 control-label">Type de contenu</label>
                    <div class="col-sm-2">
                        {!! Form::select('type', ['pub' => 'Publicité', 'text' => 'Texte', 'soutien' => 'Soutien'] , $menu->type , ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="position" class="col-sm-3 control-label">Position</label>
                    <div class="col-sm-2">
                        {!! Form::select('position', $positions, $menu->position , ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="message" class="col-sm-3 control-label">Afficher sur les pages du site</label>
                    <div class="col-sm-4">
                        @if(!$sites->isEmpty())
                            <select multiple class="form-control" name="page_id[]" style="height: 180px;">
                                @foreach($sites as $site)
                                    <optgroup label="{{ $site->nom }}">
                                        @if(!$site->pages->isEmpty())
                                            @foreach($site->pages as $page)
                                                <option {{ in_array($page->id,$menu->pages->pluck('id')->toArray()) ? 'selected' : '' }} value="{{ $page->id }}">{{ $page->title }}</option>
                                            @endforeach
                                        @endif
                                    </optgroup>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="message" class="col-sm-3 control-label">Titre</label>
                    <div class="col-sm-6">
                        {!! Form::text('title', $menu->title  , array('class' => 'form-control') ) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="contenu" class="col-sm-3 control-label">Contenu</label>
                    <div class="col-sm-6">
                        {!! Form::textarea('content', $menu->content , array('class' => 'form-control  redactor', 'cols' => '50' , 'rows' => '4' )) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="url" class="col-sm-3 control-label">Lien<br/>
                        <small class="text-muted">Sur l'image</small>
                    </label>
                    <div class="col-sm-6">
                        {!! Form::text('url', $menu->url , array('class' => 'form-control') ) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="file" class="col-sm-3 control-label">Image<br/>
                        <small class="text-muted">Pour pub ou soutien</small>
                    </label>
                    <div class="col-sm-6">
                        <p><img style="max-height:120px;" src="{{ asset('files/uploads/'.$menu->image) }}"></p>
                        <div class="list-group">
                            <div class="list-group-item">{!! Form::file('file') !!}</div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer mini-footer ">
                {!! Form::hidden('id', $menu->id ) !!}
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <button class="btn btn-primary" type="submit">Envoyer </button>
                </div>
            </div>
           </form>
        </div>
    </div>

    @endif

</div>
<!-- end row -->

@stop