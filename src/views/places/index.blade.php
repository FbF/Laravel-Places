@extends('layouts.master')

@section('title')
	{{ Config::get('laravel-places::meta.index_page.page_title') }}
@endsection

@section('meta_description')
	{{ Config::get('laravel-places::meta.index_page.meta_description') }}
@endsection

@section('meta_keywords')
	{{ Config::get('laravel-places::meta.index_page.meta_keywords') }}
@endsection

@section('content')
	@include('laravel-places::partials.list')
@stop