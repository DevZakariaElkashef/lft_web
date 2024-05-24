@extends('layouts.admin')
@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                {{ __('admin.add_new_booking') }}
            </div>
        </div>
        @include('admin.bookings.form')


    </div>
@endsection
