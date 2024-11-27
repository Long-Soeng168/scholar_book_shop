@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    @livewire('isbn-edit', [
        'id' => $id
    ])
</div>

@endsection
