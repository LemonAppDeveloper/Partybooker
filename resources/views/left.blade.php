<div class="col-md-9">
    <div class="party-heading">
        <h3 class="mb-4">My Party</h3>
    </div>
    <div id="featureContainer">
        <div class="row mx-auto my-auto justify-content-center">
            <div id="featureCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-wrap="false" data-bs-interval="false">
                <div class="carousel-indicators">
                    <?php
                    if (isset($myParty) && count($myParty) > 0) {
                        foreach ($myParty  as $key => $value) {
                    ?>
                            <button type="button" data-bs-target="#featureCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $key }}"></button>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="carousel-inner" role="listbox">
                    <?php
                    if (isset($myParty) && count($myParty) > 0) {
                        foreach ($myParty  as $key => $value) {
                    ?>
                            <div class="carousel-item {{ $key == 0 ? 'active' : ''  }}">
                                <div class="col-md-4">
                                    <div class="my-party notupdated" <?php echo 'Other class updated'; ?>>
                                        <div class="myparty-head">
                                            <h4><?php echo $value->event_title; ?></h4>
                                            <a href="javascript:void(0);"><i class="las la-briefcase"></i></a>
                                        </div>
                                        <p class="details">Details</p>
                                        <p><i class="las la-map-marker"></i> <?php echo $value->event_location; ?></p>
                                        <p><i class="las la-calendar"></i> <?php echo $value->event_date; ?></p>
                                        <p><i class="las la-fire-alt"></i> <?php echo $value->event_category; ?></p>
                                        <p>Booking list</p>
                                        <ul>
                                            
                                            <li>
                                                <a href="javascript:void(0);" class="add-image"><i class="las la-plus"></i></a>
                                                <p>Vendors</p>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="add-image"><i class="las la-plus"></i></a>
                                                <p>Vendors</p>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="add-image"><i class="las la-plus"></i></a>
                                                <p>Vendors</p>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="add-image"><i class="las la-plus"></i></a>
                                                <p>Vendors</p>
                                            </li>
                                        </ul>
                                        <a href="{{ route('my_party') }}" class="btn-trans">View my party</a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix mt-4"></div>
    <div class="categories-widget">
        <?php
        if (isset($category) && !empty($category)) {
        ?>
            <div class="cat-head">
                <h3>Categories</h3>
                <a href="#">View All </a>
            </div>
            <div class="cat-name">
                <?php
                foreach ($category as $value) {
                ?>
                    <div class="cat-name-box" <?php //other class active; 
                                                ?>>
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
        <div class="cat-list">
            <div class="slick-carousel">
                <div class="cat-list-box">
                    <div class="cat-heads" style="background-image: url({{asset('assets/images/cat-banner.png')}});">
                        <h4>Sydney Opera House</h4>
                        <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                    </div>
                    <div class="cat-body">
                        <p><img src="{{asset('assets/images/map-gray.png')}}"> Venues</p>
                        <p><img src="{{asset('assets/images/watch.png')}}"> Mon-Thur | 11:00AM-9:00PM</p>
                        <div class="star-rating">
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star-half"></i>
                        </div>
                        <div class="desc">
                            <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                        </div>
                        <a href="javascript:void(0);" class="view-all-review">View details</a>
                    </div>
                </div>

                <div class="cat-list-box">
                    <div class="cat-heads" style="background-image: url({{asset('assets/images/cat-banner.png')}});">
                        <h4>Sydney Opera House</h4>
                        <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                    </div>
                    <div class="cat-body">
                        <p><img src="{{asset('assets/images/map-gray.png')}}"> Venues</p>
                        <p><img src="{{asset('assets/images/watch.png')}}"> Mon-Thur | 11:00AM-9:00PM</p>
                        <div class="star-rating">
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star-half"></i>
                        </div>
                        <div class="desc">
                            <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                        </div>
                        <a href="javascript:void(0);" class="view-all-review">View details</a>
                    </div>
                </div>

                <div class="cat-list-box">
                    <div class="cat-heads" style="background-image: url({{asset('assets/images/cat-banner.png')}});">
                        <h4>Sydney Opera House</h4>
                        <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                    </div>
                    <div class="cat-body">
                        <p><img src="{{asset('assets/images/map-gray.png')}}"> Venues</p>
                        <p><img src="{{asset('assets/images/watch.png')}}"> Mon-Thur | 11:00AM-9:00PM</p>
                        <div class="star-rating">
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star-half"></i>
                        </div>
                        <div class="desc">
                            <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                        </div>
                        <a href="javascript:void(0);" class="view-all-review">View details</a>
                    </div>
                </div>

                <div class="cat-list-box">
                    <div class="cat-heads" style="background-image: url({{asset('assets/images/cat-banner.png')}});">
                        <h4>Sydney Opera House</h4>
                        <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                    </div>
                    <div class="cat-body">
                        <p><img src="{{asset('assets/images/map-gray.png')}}"> Venues</p>
                        <p><img src="{{asset('assets/images/watch.png')}}"> Mon-Thur | 11:00AM-9:00PM</p>
                        <div class="star-rating">
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star-half"></i>
                        </div>
                        <div class="desc">
                            <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                        </div>
                        <a href="javascript:void(0);" class="view-all-review">View details</a>
                    </div>
                </div>

                <div class="cat-list-box">
                    <div class="cat-heads" style="background-image: url({{asset('assets/images/cat-banner.png')}});">
                        <h4>Sydney Opera House</h4>
                        <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                    </div>
                    <div class="cat-body">
                        <p><img src="{{asset('assets/images/map-gray.png')}}"> Venues</p>
                        <p><img src="{{asset('assets/images/watch.png')}}"> Mon-Thur | 11:00AM-9:00PM</p>
                        <div class="star-rating">
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star-half"></i>
                        </div>
                        <div class="desc">
                            <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                        </div>
                        <a href="javascript:void(0);" class="view-all-review">View details</a>
                    </div>
                </div>

                <div class="cat-list-box">
                    <div class="cat-heads" style="background-image: url({{asset('assets/images/cat-banner.png')}});">
                        <h4>Sydney Opera House</h4>
                        <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                    </div>
                    <div class="cat-body">
                        <p><img src="{{asset('assets/images/map-gray.png')}}"> Venues</p>
                        <p><img src="{{asset('assets/images/watch.png')}}"> Mon-Thur | 11:00AM-9:00PM</p>
                        <div class="star-rating">
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star-half"></i>
                        </div>
                        <div class="desc">
                            <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                        </div>
                        <a href="javascript:void(0);" class="view-all-review">View details</a>
                    </div>
                </div>

                <div class="cat-list-box">
                    <div class="cat-heads" style="background-image: url({{asset('assets/images/cat-banner.png')}});">
                        <h4>Sydney Opera House</h4>
                        <a href="javascript:void(o);"><i class="las la-heart"></i></a>
                    </div>
                    <div class="cat-body">
                        <p><img src="{{asset('assets/images/map-gray.png')}}"> Venues</p>
                        <p><img src="{{asset('assets/images/watch.png')}}"> Mon-Thur | 11:00AM-9:00PM</p>
                        <div class="star-rating">
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star"></i>
                            <i class="las la-star-half"></i>
                        </div>
                        <div class="desc">
                            <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                        </div>
                        <a href="javascript:void(0);" class="view-all-review">View details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('pageScript')
<script type="text/javascript">
    $('#partydropdowns').on('click', function(event) {
        event.stopPropagation();
    });
    let items = document.querySelectorAll('#featureContainer .carousel .carousel-item');
    items.forEach((el) => {
        const minPerSlide = 1
        let next = el.nextElementSibling
        for (var i = 1; i < minPerSlide; i++) {
            if (!next) {
                next = items[0]
            }
            let cloneChild = next.cloneNode(true)
            el.appendChild(cloneChild.children[0])
            next = next.nextElementSibling
        }
    });
    $(document).ready(function() {
        $('#featureCarousel').carousel({
            interval: 1000 * 100,
            interval: false,
            wrap: false,
            pause: true
        });
        $('#featureCarousel').carousel('pause');
    });
</script>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.slick-carousel').slick({
            arrows: false,
            centerPadding: "0px",
            dots: false,
            infinite: true,
            slidesToShow: 4,
            centerMode: true,
            responsive: [{
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 540,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    });
</script>
@endsection