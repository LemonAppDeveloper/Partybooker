<div class="modal fade event-action-modal" id="bookingopt" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bookingoptLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingoptLabel">Booking List Options</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-outline-dark btn-block btn-edit-event" data-href="{{ route('event.detail') }}" data-id="">Edit my Party</button>
                <button type="button" class="btn btn-danger btn-block btn-delete-event" data-href="{{ route('event.delete') }}" data-id="">Delete Party</button>
            </div>
        </div>
    </div>
</div>