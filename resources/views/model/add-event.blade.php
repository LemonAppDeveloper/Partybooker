<div class="modal fade" id="organizeparty" tabindex="-1" aria-labelledby="editproLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editproLabel">Let’s organize<br>your party</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Let us serve you better (fill up all the details needed).</p>
                <form action="{{ route('createEvent') }}" name="create-event" method="POST" onsubmit="return false;">
                    @csrf
                    <input type="hidden" name="id" value="" />
                    <input type="text" name="title" class="form-control mb-4" placeholder="Add a title of the event">
                    <div class="input-group">
                        <span class="input-group-append input-group-addon">
                            <span class="input-group-text"><i class="las la-map-marker"></i></span>
                        </span>
                        <input type="text" name="location" class="form-control" placeholder="Add location of the party">
                    </div>
                    <div class="input-group date" id="datepicker">
                        <span class="input-group-append input-group-addon">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                        </span>
                        <input class="form-control" name="event_date" placeholder="MM/DD/YYYY" readonly>
                    </div>
                    <div class="input-group date" id="datepicker_to">
                        <span class="input-group-append input-group-addon">
                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                        </span>
                        <input class="form-control" name="event_to_date" placeholder="MM/DD/YYYY" readonly>
                    </div>
                    <div class="input-group category">
                        <span class="input-group-append input-group-addon">
                            <span class="input-group-text"><i class="las la-fire-alt"></i></span>
                        </span>
                        <input type="text" name="category" class="form-control" placeholder="Add category">
                    </div>
                    <button type="submit" class="btn btn-gradient"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Create</button>
                </form>
            </div>
        </div>
    </div>
</div>