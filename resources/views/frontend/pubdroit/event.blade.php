@extends('frontend.pubdroit.layouts.master')
@section('content')
	
    <div id="events" class="inner">
	<?php
		echo '<pre>';
		print_r($events);
		echo '</pre>';
	?>
    </div>
	
@stop
