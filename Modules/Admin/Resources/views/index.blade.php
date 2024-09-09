@extends('layouts.admin.app')
@section('content')
    <div class="row">
        <div class="col-lg-9 overflow">
            <div class="row">
                <div class="col-md-4">
                    <div class="widget-breakdown">
                        <div class="widget-head">
                            <h3>User Statistics</h3>
                            
                        </div>
                        <div class="widget-body">
                            <div class="report-count">
                                <div class="cancelled">
                                    <p><img src="{{ asset('admin-assets/images/uninstalled.png') }}">Banned</p>
                                    <h3>{{ $inactive_users }} Users</h3>
                                </div>
                                <div class="ongoing">
                                    <p><img src="{{ asset('admin-assets/images/inactive.png') }}">Total</p>
                                    <h3>{{ $totalusers }} Users</h3>
                                </div>
                                <div class="completed">
                                    <p><img src="{{ asset('admin-assets/images/active.png') }}">Active </p>
                                    <h3>{{ $active_users }}</h3>
                                </div>
                            </div>
                            <div class="report-progress">
                                <img src="{{ asset('admin-assets/images/breakdown.png') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="average-revenue">
                        <div class="average-head">
                            <h3>User Breakdown</h3>
                            <div class="graph-info">
                                <p><span class="orange"></span> Users</p>
                                <p><span class="avarage"></span> Vendors</p>
                                <form method="GET" action="{{ url('admin/dashboard') }}" id="yearForm">
                                    <select name="selectedYear" id="yearDropdown">
                                        @foreach ($yearsList as $year)
                                            <option value="{{ $year }}"
                                                {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class='graph-wrapper'>
                            <div class='graph' id='pushups'></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="order-derails">
                        <div class="order-head">
                            <h3>Vendor Statistics</h3>
                            {{-- <div class="graph-info graph-filter">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">All <i
                                            class="las la-angle-down"></i></button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="javascript:void(0);">All</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Highest - Lowest</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Lowest - Highest</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Alphabetically A-Z</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Alphabetically Z-A</a></li>
                                    </ul>
                                </div>

                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">By Vendors <i
                                            class="las la-angle-down"></i></button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="javascript:void(0);">By Vendors</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">By Location</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">By Booking</a></li>
                                    </ul>
                                </div>
                            </div> --}}
                        </div>
                        <div class="statistics-details">
                            <!-- Your other HTML content -->
                            @foreach ($categoryCounts as $category)
                                <div class="statistics-box">
                                    <span><span></span>{{ $category->category_name }}</span>
                                    <p>{{ $category->user_count }} Users</p>
                                </div>
                            @endforeach
                            <!-- Your other HTML content -->
                        </div>
                        <?php
                        $vendor_statistics = [
                            'label' => [],
                            'color' => [],
                            'data' => [],
                        ];
                        $colors = ['#fba6a3', '#fdc2a3', '#fae990', '#a884d3', '#82ec99', '#e3ac90', '#a884d3'];
                        $color_count = 0;
                        foreach ($categoryCounts as $category) {
                            $vendor_statistics['label'][] = $category->category_name;
                            $vendor_statistics['color'][] = $colors[$color_count];
                            $vendor_statistics['data'][] = $category->user_count;
                            $color_count++;
                            if ($color_count >= count($colors)) {
                                
                                $color_count = 0;
                            }
                        }
                        ?>
                        <div class="wrapper c-info">
                            <canvas id="myChart4"></canvas>
                            <span class="d-none">* Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint.
                                Velit officia
                                consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 overflow">
            <div class="row">
                <div class="col-md-12">
                    <div class="vendor-details">
                        <div class="vdt-head">
                            <h3>Top Countries</h3>
                            <a href="javascript:void(0);" class="d-none">View all</a>
                        </div>
                        <div class="countries-list">
                            @foreach ($countryWiseUserCount as $country)
                                <div class="c-list">
                                    <div class="c-name">
                                        <!-- Assuming $country->country contains country code -->
                                        <?php 
                                             
                                            $topLevelDomain = \DB::table('tbl_country')
                                                                ->where('country_name', $country->country)
                                                                ->pluck('top_level_domain')
                                                                ->first();
                                        ?>
                                        @if($topLevelDomain)
                                            <img src="{{ asset('admin-assets/images/flags/' . $topLevelDomain . '.png') }}">
                                        @endif
                                       
                                        <p>{{ !empty($country->country) ? $country->country : '--' }}</p>
                                    </div>
                                    <b>{{ $country->user_count }} Users</b>
                                    <!-- If you have another variable for the respective amount -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('pageScript')
    <script>
        var userCounts = [];
        var categoryNames = [];
        var categoryCounts = @json($categoryCounts);

        categoryCounts.forEach(function(category) {
            userCounts.push(category.user_count);
            categoryNames.push(category.category_name);
        });

        console.log(userCounts);
        console.log(categoryNames);
        $(document).ready(function() {
            $('#yearDropdown').change(function() {
                $('#yearForm').submit();
            });
        });
        var vendor_statistics_label = <?php echo json_encode($vendor_statistics['label']); ?>;
        var vendor_statistics_color = <?php echo json_encode($vendor_statistics['color']); ?>;
        var vendor_statistics_data = <?php echo json_encode($vendor_statistics['data']); ?>;
    </script>

    <script type="text/javascript">
        current_year = {!! json_encode($current_year) !!};
        jan_users = {!! json_encode($jan_users) !!};
        jan_vendor = {!! json_encode($jan_vendor) !!};

        feb_users = {!! json_encode($feb_users) !!};
        feb_vendor = {!! json_encode($feb_vendor) !!};

        march_users = {!! json_encode($march_users) !!};
        march_vendor = {!! json_encode($march_vendor) !!};

        april_users = {!! json_encode($april_users) !!};
        april_vendor = {!! json_encode($april_vendor) !!};

        may_users = {!! json_encode($may_users) !!};
        may_vendor = {!! json_encode($may_vendor) !!};

        jun_users = {!! json_encode($jun_users) !!};
        jun_vendor = {!! json_encode($jun_vendor) !!};

        july_users = {!! json_encode($july_users) !!};
        july_vendor = {!! json_encode($july_vendor) !!};

        aug_users = {!! json_encode($aug_users) !!};
        aug_vendor = {!! json_encode($aug_vendor) !!};

        sep_users = {!! json_encode($sep_users) !!};
        sep_vendor = {!! json_encode($sep_vendor) !!};

        oct_users = {!! json_encode($oct_users) !!};
        oct_vendor = {!! json_encode($oct_vendor) !!};

        nov_users = {!! json_encode($nov_users) !!};
        nov_vendor = {!! json_encode($nov_vendor) !!};

        dec_users = {!! json_encode($dec_users) !!};
        dec_vendor = {!! json_encode($dec_vendor) !!};
        // Load graph
        new Morris.Line({
            element: 'pushups',
            data: [{
                    day: 'Jan ' + current_year,
                    user: jan_users,
                    vendor: jan_vendor
                },
                {
                    day: 'Feb ' + current_year,
                    user: feb_users,
                    vendor: feb_vendor
                },
                {
                    day: 'March ' + current_year,
                    user: march_users,
                    vendor: march_vendor
                },
                {
                    day: 'April ' + current_year,
                    user: april_users,
                    vendor: april_vendor
                },
                {
                    day: 'May ' + current_year,
                    user: may_users,
                    vendor: may_vendor
                },
                {
                    day: 'Jun ' + current_year,
                    user: jun_users,
                    vendor: jun_vendor
                },
                {
                    day: 'July ' + current_year,
                    user: july_users,
                    vendor: july_vendor
                },
                {
                    day: 'Aug ' + current_year,
                    user: aug_users,
                    vendor: aug_vendor
                },
                {
                    day: 'Sep ' + current_year,
                    user: sep_users,
                    vendor: sep_vendor
                },
                {
                    day: 'Oct ' + current_year,
                    user: oct_users,
                    vendor: oct_vendor
                },
                {
                    day: 'Nov ' + current_year,
                    user: nov_users,
                    vendor: nov_vendor
                },
                {
                    day: 'Dec ' + current_year,
                    user: dec_users,
                    vendor: dec_vendor
                }
            ],

            xkey: 'day',
            parseTime: false,
            ykeys: ['user', 'vendor'],
            labels: ['user', 'vendor'],
            lineColors: ['#FB8547', '#963CFF']
        });
        // End graph js
    </script>
    <script src="{{ asset('admin-assets/js/popper.min.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js'></script>
    <script src="{{ asset('admin-assets/js/vendor-activity.js') }}"></script>
@endsection
