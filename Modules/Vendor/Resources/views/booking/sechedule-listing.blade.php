@foreach ($data as $val)
<div class="working-hours {{ $val->is_active == 0 ? 'inactive' : '' }}">
    <div class="working-head">
        <h4>{{$val->title}}</h4>
        <a href="javascript:void(0);" class="make-default-time" data-id="{{$val->id}}"><i class="las la-check"></i></a>
    </div>
    <span class="d-none">Default</span>
    <p>{{$val->from_time}} - {{$val->to_time}}</p>
    <span>({{$val->from_date}} - {{$val->to_date}})</span>
    <a href="javascript:void(0);" class="view-all-review edit-schedule" data-detail="{{base64_encode(json_encode($val))}}">Edit Schedule</a>
</div>
@endforeach