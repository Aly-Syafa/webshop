@extends('frontend.bail.layouts.master')
@section('content')

	 <div id="content" class="inner">
	 	 <div class="row">
	 	 	<div class="col-md-12">
		 	 	<h5 class="line">Contactez-nous</h5>

				<div class="row">
					<div class="col-md-8">
						<form action="{{ url('sendMessage') }}" class="form-horizontal" method="post">
							<div class="form-group">
								<label class="col-sm-2 control-label">Nom</label>
								<div class="col-sm-10">
									<input type="text" name="nom" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="email" name="email" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Remarque</label>
								<div class="col-sm-10">
									<textarea name="remarque" required class="form-control" rows="3"></textarea>
								</div>
							</div>
							<input value="Envoyer" class="btn btn-default" type="submit" />
						</form><!--END CONTACT FORM-->
					</div>
					<div class="col-md-4">

						<h4>{!! Registry::get('shop.infos.nom') !!}</h4>
						<p>{!! Registry::get('shop.infos.adresse') !!}</p>
						<p><a href="mailto:{{ Registry::get('shop.infos.email') }}">{{ Registry::get('shop.infos.email') }}</a></p>

					</div>
				</div>

	 	 	</div>
	 	 </div>
	 </div>

@stop