@php $isPartial = $partial ?? false; @endphp

@if($isPartial)
    @include('amenties._phong_content')
@else
    @extends('layouts.admin')

    @section('title', 'Quản lý Phòng')
    @section('page-title', 'Quản lý Phòng')

    @section('content')
        @include('amenties._phong_content')
    @endsection

    @push('scripts')
        <script src="{{ asset('assets/js/pages/phong.js') }}"></script>
    @endpush
@endif
