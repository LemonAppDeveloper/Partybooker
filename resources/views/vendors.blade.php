@extends('layouts.app')
@section('content')

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="party-heading">
                <h3 class="mb-4">Best Results</h3>
            </div>
        </div>
        <div class="col-lg-9 search-result overflow overflow-h">
            <div class="row">
                <?php
                if (isset($vendor_info) && !empty($vendor_info)) {
                    foreach ($vendor_info as $value) {
                ?>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="cat-list-box">
                                <div class="cat-heads">
                                    <img src="<?php echo $value->banner_url; ?>">
                                </div>
                                <div class="cat-body">
                                    <div class="search-head">
                                        <h4><?php echo $value->name; ?></h4>
                                        <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                                    </div>
                                    <p><img src="{{ asset('assets/images/map-gray.png') }}"> <?php echo !empty($value->address) ? $value->address : '-'; ?></p>
                                    <p><img src="{{ asset('assets/images/watch.png') }}"> <?php echo !empty($value->timing) ? $value->timing : '-'; ?></p>
                                    <div class="star-rating">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $value->avg_rating) {
                                                echo '<i class="las la-star"></i>';
                                            } else {
                                                echo '<i class="las la-star empty"></i>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="desc">
                                        <p><?php echo nl2br($value->description); ?></p>
                                    </div>
                                    <a href="javascript:void(0);" class="view-all-review">View details</a>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                 ?>
            </div>
        </div>

        <div class="col-lg-3 overflow overflow-h">
            <div class="widget mywedding-widget search-page-wid">
                <div class="mywedding-head mb-4">
                    <h3>Search Settings</h3>
                </div>
                <div class="short-by">
                    <p>Sort by</p>
                    <i class="las la-minus d-none"></i>
                </div>
                <nav>
                    <div class="nav nav-tabs justify-content-center nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-link active" href="javascript:void(0)" id="popularity-tab" data-bs-toggle="tab" data-bs-target="#popularity" type="button" role="tab" aria-controls="popularity" aria-selected="true">Popularity</a>
                        <a class="nav-link" href="javascript:void(0)" id="newest-tab" data-bs-toggle="tab" data-bs-target="#newest" type="button" role="tab" aria-controls="newest" aria-selected="false">Newest</a>
                        <a class="nav-link" href="javascript:void(0)" id="oldest-tab" data-bs-toggle="tab" data-bs-target="#oldest" type="button" role="tab" aria-controls="oldest" aria-selected="false">Oldest</a>
                    </div>
                </nav>
                <div class="tab-content pt-3 bg-white" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="popularity" role="tabpanel" aria-labelledby="popularity-tab">
                    </div>
                    <div class="tab-pane fade" id="newest" role="tabpanel" aria-labelledby="newest-tab">
                    </div>
                    <div class="tab-pane fade" id="oldest" role="tabpanel" aria-labelledby="oldest-tab">
                    </div>
                </div>
                <div class="mywedding-head mt-4 mb-4 d-none">
                    <p class="mb-0">Party Details</p>
                    <a href="javascript:void(0);">Edit</a>
                </div>
                <div class="party-det d-none">
                    <div class="det-box">
                        <i class="las la-map-marker"></i>
                        <p>856 E 23rd St..</p>
                    </div>
                    <div class="det-box">
                        <i class="las la-calendar"></i>
                        <p>Aug 23, 9-7PM</p>
                    </div>
                    <div class="det-box">
                        <i class="las la-fire"></i>
                        <p>Weddings</p>
                    </div>
                </div>
                <p class="mb-4">Categories</p>
                <?php
                if (isset($category) && !empty($category)) {
                ?>
                    <div class="cat-name d-block">
                        <div class="cat-name-box active float-start">
                            <a href="javascript:void(0);"><img src="{{ asset('assets/images/p-icon.png') }}"></a>
                            <p>All</p>
                        </div>
                        <?php
                        foreach ($category as $value) {
                        ?>
                            <div class="cat-name-box float-start">
                                <a href="javascript:void(0);"><img src="{{ $value->category_icon_url }}"></a>
                                <p>{{ $value->category_name }}</p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

@endsection
@section('pageScript')
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js')}}"></script>
@endsection
@section('pageScriptlinks')
@endsection