@extends("layouts.admin")
@section("content")
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                {{ __('admin.edit_agent') }}
            </div>
        </div>
        @include('admin.agents.form')
    </div>
@endsection
