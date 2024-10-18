@extends('layouts.admin')

@section('title', trans('global.dashboard'))

@section('custom_css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('main-content')
<div class="page-title-box">
    <h4 class="page-title">{{ trans('global.welcome') }}</h4>
</div>
<div class="row">
    <div class="col-xxl-3 col-sm-6">
        <div class="card widget-flat">
            <div class="card-body">
                <a class="dashboard-card" href="{{-- {{ route('api.tasks.index') }} --}}">
                    <div class="dashboard-card-icon">
                        <i class="ri-group-line widget-icon"></i>
                    </div>
                    <h2 class="blue-shade">0</h2>
                    <h6 title="Customers">@lang('cruds.task.title')</h6>
                </a>
            </div>
        </div>
    </div>
</div>


@endsection

@section('custom_js')
<script src="{{ asset('backend/vendor/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('backend/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('backend/vendor/daterangepicker/daterangepicker.js') }}"></script>
@endsection