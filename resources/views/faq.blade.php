@extends('layouts.app')
@section('content')
<section id="contact-page">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="page-headings text-center p-0">
                    <h1>Frequently Asked Questions</h1>
                    <div class="search-tems">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="terms"><i class="las la-search"></i></span>
                            <input type="text" class="form-control" id="faq-search" placeholder="Search" aria-label="search" aria-describedby="terms">
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-6 col-md-12 offset-lg-3 offset-md-0 faq">
                <div class="accrdings" id="faq-accordion">
                    @foreach ($data as $val)
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="heading{{$val->id}}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$val->id}}" aria-expanded="false" aria-controls="collapseOne">
                                    {{ $val->question}}
                                </button>
                            </h3>
                            <div id="collapse{{$val->id}}" class="accordion-collapse collapse  " aria-labelledby="heading{{$val->id}}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>{{ $val->answer }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('pageScript')
<script type="text/javascript">
    $(document).ready(function() {
        $('#faq-search').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: "{{ route('faq.search') }}",
                type: "GET",
                data: {'query': query},
                success: function(data) {
                    var accordion = $('#faq-accordion');
                    accordion.empty();
                    $.each(data, function(index, value) {
                        accordion.append(
                            '<div class="accordion" id="accordionExample">' +
                            '<div class="accordion-item">' +
                            '<h3 class="accordion-header" id="heading'+value.id+'">' +
                            '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'+value.id+'" aria-expanded="false" aria-controls="collapseOne">' +
                            value.question +
                            '</button>' +
                            '</h3>' +
                            '<div id="collapse'+value.id+'" class="accordion-collapse collapse" aria-labelledby="heading'+value.id+'" data-bs-parent="#accordionExample">' +
                            '<div class="accordion-body">' +
                            '<p>' + value.answer + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );
                    });
                }
            });
        });
    });
</script>
@endsection
