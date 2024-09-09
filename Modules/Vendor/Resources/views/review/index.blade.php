@extends('layouts.vendor.app')
@section('pageStyles')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="pheading">
                        <h2><a href="{{ route('dashboard') }}"><i class="las la-arrow-left"></i></a> Reviews</h2>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-10 offset-md-1">
                    <div class="reviewss">
                        <div class="review-heading">
                            <h2><i class="las la-star-half-alt"></i> <?php echo $average_review; ?>/5.0 Overall Rating</h2>
                            <select class="form-select apply-filter">
                                <option value="<?php echo route('review'); ?>?sort_by=highest" {{ isset($sort_by) && $sort_by == 'highest' ? 'selected' : '' }}> Highest Rated</option>
                                <option value="<?php echo route('review'); ?>?sort_by=latest" {{ isset($sort_by) && $sort_by == 'latest' ? 'selected' : '' }}> Lastest Rated</option>
                                <option value="<?php echo route('review'); ?>?sort_by=oldest" {{ isset($sort_by) && $sort_by == 'oldest' ? 'selected' : '' }}> Oldest Rated</option>
                            </select>
                        </div>
                        <?php
                        if (isset($review_info) && !empty($review_info)) {
                            foreach ($review_info as $value) {
                                $words = explode(" ", $value->full_name);
                                $acronym = "";
                                foreach ($words as $w) {
                                    $acronym .= mb_substr($w, 0, 1);
                                }
                        ?>
                                <div class="review-list">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="revuser">
                                                <span><?php echo $acronym; ?></span>
                                                <b><?php echo $value->full_name; ?></b>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="revi">
                                                <strong>
                                                    <?php
                                                    for ($i = 1; $i <= 5; $i++) {
                                                    ?>
                                                        <i class="las <?php echo $i <= $value->rating ? 'la-star' : 'la-star-half-alt'; ?>"></i>
                                                    <?php
                                                    }
                                                    ?>
                                                </strong>
                                                <b class="d-none">Great Product!</b>
                                                <span><?php echo date('d/m/Y', strtotime($value->created_at)); ?></span>
                                                <p>
                                                    <?php echo nl2br($value->review); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                        <div class="review-pagination text-end d-none">
                            <a href="#" class="active">1</a>
                            <a href="#">2</a>
                            <a href="#">3</a>
                            <span>...</span>
                            <a href="#">9</a>
                            <a href="#">10</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.vendor.modal-profile')
@include('layouts.vendor.modal-calendar')
@include('layouts.vendor.modal-settings')
@endsection
@section('pageScript')
<script>
    $(document).ready(function() {
        $('.apply-filter').change(function() {
            window.location.href = $(this).val();
        });
    });
</script>
@endsection