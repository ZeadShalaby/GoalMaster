@extends('layouts.app')
@section('content')
<div class="page-inner">
    <!-- category datatable -->
    <div class="row">
        <div class="col-md-12">
            <div class="main-card card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">
                            {{translate('Booking Info') . ' (' . "المسامح كريم". ')'}}
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tableElement" class="table table-bordered w100"></table>
                </div>
            </div>
        </div>
    </div>
</div>
@push("adminScripts")
<script src="{{dsAsset('js/custom/booking/forgiving-generous.js')}}"></script>
@endpush
@endsection