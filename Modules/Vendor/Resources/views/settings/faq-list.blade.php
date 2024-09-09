<?php
if (isset($data['faq_info']) && count($data['faq_info']) > 0) {
    foreach ($data['faq_info'] as $value) {
?>
        <div class="olists btn-select-template <?php echo isset($value['id']) && $value['id'] == $value->id ? 'active' : ''; ?>" data-detail="<?php echo base64_encode(json_encode($value)); ?>">
            <div>
                <b><?php echo $value->question; ?></b>
                <p><?php echo $value->answer ?></p>
            </div>
            <div class="option">
                <div class="dropdown">
                    <a class="btn dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="las la-ellipsis-v"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item btn-delete-faq" data-id="<?php echo isset($value['id']) ? $value['id'] : ''; ?>" data-url="{{route('vender.configration.faq.delete')}}" href="javascript:void(0);">Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
<?php
    }
}
