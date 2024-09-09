@extends('layouts.vendor.app')
@section('pageStyles')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('vendor-assets/css/settings.css') }}" />
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="pheading" style="margin-bottom: 20px;">
                        <h2><a href="{{ route('vender.configration') }}"><i class="las la-arrow-left"></i></a> Bank Details</h2>
                    </div>
                </div>
                {{-- <div class="col-md-4 text-end">
                    
                </div> --}}
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="order-conf">
                        <div class="ord-header">
                            <h3 class="title form-title">Add Bank Details </h3>
                            {{-- <button class="btn btn-secondary  btn-green btn-add">Add New</button> --}}
                        </div>
                        @if($bank_data->isNotEmpty())
                            @foreach ($bank_data as $val)
                            <form action="{{ route('vender.configration.bank') }}" name="form-add" onsubmit="return false;">
                                @csrf
                                <input type="hidden" name="id" />
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <input type="text" name="bank_name" placeholder="Bank Name" value="{{$val->bank_name}}" class="form-control" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <input type="text" name="code" placeholder="Code" class="form-control" value="{{$val->code}}"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <input type="text" name="account_no" placeholder="Account Number" value="{{$val->account_no}}" class="form-control" />
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="button" class="btn btn-green btn-submit"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Save Changes</button>
                                    </div>
                                </div>
                            </form>
                            @endforeach
                        @else
                            <form action="{{ route('vender.configration.bank') }}" name="form-add" onsubmit="return false;">
                                @csrf
                                <input type="hidden" name="id" />
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <input type="text" name="bank_name" placeholder="Bank Name"  class="form-control" />
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <input type="text" name="code" placeholder="Code" class="form-control"  />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <input type="text" name="account_no" placeholder="Account Number"   class="form-control" />
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="button" class="btn btn-green btn-submit"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '.btn-select-template', function() {
            $('.form-title').text('Update');
            $('.btn-select-template').removeClass('active');
            var current = $(this);
            current.addClass('active');
            var detail = JSON.parse(atob(current.attr('data-detail')));
            $('[name="question"]').val(detail.question);
            $('[name="answer"]').val(detail.answer);
            $('[name="id"]').val(detail.id);
        });

        $('.btn-add').click(function() {
            $('.form-title').text('Add New');
            $('[name="question"]').val('');
            $('[name="answer"]').val('');
            $('[name="id"]').val('');
        });

        $('.btn-submit').click(function() {
            $('[name="form-add"]').submit();
        }); 
        $('[name="form-add"]').submit(function() {
            var current = $(this);
            $('.custom-validation-message').remove();
            $('.btn-submit').find('.spinner-border').removeClass('d-none');
            $('.btn-submit').attr('disabled', 'disabled');
            $.ajax({
                url: current.attr('action'),
                type: 'POST',
                data: $('[name="form-add"]').serialize(),
                dataType: 'json',
                success: function(response) {
                    $('.btn-submit').find('.spinner-border').addClass('d-none');
                    $('.btn-submit').removeAttr('disabled');
                    if (response.status) {
                        $('.btn-add').trigger('click');
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location = window.location.href;
                        }, 1000);
                    } else {
                        if (typeof response.message == 'object') {
                            $.each(response.message, function(index, message) {
                                $('<p class="text-danger custom-validation-message">' + message + '</p>').insertAfter('[name="' + input + '"]');
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(reject) {
                    $('.btn-submit').find('.spinner-border').addClass('d-none');
                    $('.btn-submit').removeAttr('disabled');
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function(input, val) {
                            $('<p class="text-danger custom-validation-message">' + val[0] + '</p>').insertAfter('[name="' + input + '"]');
                        });
                    }
                }
            });
        });

        
    });

    
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

</script>
@include('layouts.vendor.modal-profile')
@include('layouts.vendor.modal-calendar')
@include('layouts.vendor.modal-settings')
@endsection