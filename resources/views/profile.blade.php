@extends('layout')

@section('title', 'User Profile')

@section('content')
    <profile-page :user-id="{{ $id }}"></profile-page>
@endsection
