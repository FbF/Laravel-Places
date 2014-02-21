@extends('layouts.master')

@section('title')
	{{ $place->page_title }}
@endsection

@section('meta_description')
	{{ $place->meta_description }}
@endsection

@section('meta_keywords')
	{{ $place->meta_keywords }}
@endsection

@section('content')
	@include('laravel-places::partials.details')
@stop