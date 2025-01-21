@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    @livewire('adjustment-show', [
        'id' => $id
    ])
</div>

@endsection
