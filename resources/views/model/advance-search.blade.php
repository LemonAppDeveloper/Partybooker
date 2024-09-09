<div class="modal fade" id="advancedsearch" tabindex="-1" aria-labelledby="advancedsearchLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="advancedsearchLabel">Advanced Search</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mode-search">
                    <div class="input-group">
                        <span class="input-group-append input-group-addon">
                            <span class="input-group-text"><i class="las la-search"></i></span>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Search nearby events">
                    </div>
                </div>
                <div class="short-by">
                    <p>Advanced filtering</p>
                    <i class="las la-minus"></i>
                </div>
                <div class="my-details">
                    <p><i class="las la-map-marker"></i> Add location of the party</p>
                    <div class="date-time">
                        <div class="left-side">
                            <i class="las la-calendar"></i>
                            <p>Add preferred day</p>
                        </div>
                        <div class="right-side">
                            <i class="las la-stopwatch"></i>
                            <p>Add preferred time</p>
                        </div>
                    </div>
                    <p><i class="las la-fire"></i> Add specific category</p>
                </div>
                <div class="short-by">
                    <p>Advanced filtering</p>
                    <i class="las la-minus"></i>
                </div>

                <div class="short-dates">
                    <nav>
                        <div class="nav nav-tabs justify-content-center nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-link" href="javascript:void(0)" id="popularity-tab" data-bs-toggle="tab" data-bs-target="#popularity" type="button" role="tab" aria-controls="popularity" aria-selected="true">Popularity</a>
                            <a class="nav-link active" href="javascript:void(0)" id="newest-tab" data-bs-toggle="tab" data-bs-target="#newest" type="button" role="tab" aria-controls="newest" aria-selected="false">Newest</a>
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
                    <a href="#" class="btn btn-search d-block">Search</a>
                </div>
            </div>
        </div>
    </div>
</div>