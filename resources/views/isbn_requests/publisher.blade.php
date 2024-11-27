@extends('admin.layouts.admin')

@section('content')
<div>
    @livewire('publisher-show', [
        'id' => $id
    ])
</div>

@endsection
