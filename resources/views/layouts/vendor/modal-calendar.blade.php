<div class="calender-model">
	<div class="modal-header">
		<h5 class="modal-title" id="schedulesModalLabel">My Schedule</h5>
		<a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></a>
	</div>
	<div class="modal-body cal-list">
		<div class="list-details">
			<div class="list-header">
				<h3>February 17 <br><span>Thursday,</span></h3>
				<div class="time-filter">
					<span>Time Availability:</span>
					<p>From: <span>9:00AM</span> <i class="las la-angle-down"></i></p>
					<p>To: <span>9:00AM</span> <i class="las la-angle-down"></i></p>
				</div>
			</div>
			<div class="list-search">
				<div class="input-group">
					<span class="input-group-append input-group-addon">
						<span class="input-group-text"><i class="las la-search"></i></span>
					</span>
					<input type="text" name="search" class="form-control" placeholder="Search">
				</div>
				<div class="input-group">
					<span class="input-group-append input-group-addon">
						<span class="input-group-text"><i class="las la-filter"></i></span>
					</span>
					<select class="form-control">
						<option>All</option>
					</select>
				</div>
			</div>
			<div class="todo-list">
				<div id="calendar"></div>
			</div>
		</div>
		<div class="list-calender">
			<img src="{{ asset('vendor-assets/images/calendar.png') }}" style="max-width: 100%;">
			<a href="#" class="view-all-review">Export Schedule</a>
			<hr>
			<h3>Your Time Schedule</h3>
			<p><i class="las la-plus"></i> Add new schedule</p>
			<div class="working-hours">
				<div class="working-head">
					<h4>Work Hours</h4>
					<a href="#"><i class="las la-check"></i></a>
				</div>
				<span>Default</span>
				<p>9:00AM - 6:00PM</p>
				<span>(No set Date)</span>
				<a href="#" class="view-all-review">Edit Schedule</a>
			</div>
			<div class="working-hours">
				<div class="working-head">
					<h4>Holidays</h4>
					<a href="#"><i class="las la-check"></i></a>
				</div>
				<p>9:00AM - 12:00PM</p>
				<span>(No set Date)</span>
				<a href="#" class="view-all-review">Edit Holidays</a>
			</div>
		</div>
	</div>
</div>