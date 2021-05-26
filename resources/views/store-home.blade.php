@extends('layouts.app')

@section('content')

{{View::make('store-header')}}


@endsection

@section('scripts')
<script src="{{ asset('js/store.js') }}" defer></script>
@endsection