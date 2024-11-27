@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    @livewire('isbn-show', [
        'id' => $id
    ])
</div>

@endsection
