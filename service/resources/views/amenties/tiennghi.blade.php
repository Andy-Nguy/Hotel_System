@php $isPartial = $partial ?? false; @endphp

@if($isPartial)
    @include('amenties._tiennghi_content')
@else
    @extends('layouts.admin')

    @section('title', 'Quản lý Tiện nghi')
    @section('page-title', 'Quản lý Tiện nghi')

    @section('content')
        @include('amenties._tiennghi_content')
    @endsection

    @push('scripts')
        <script src="{{ asset('assets/js/pages/tiennghi.js') }}"></script>
    @endpush
@endif