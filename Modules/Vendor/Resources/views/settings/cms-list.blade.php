<?php
if (isset($data['cms_pages_info']) && count($data['cms_pages_info']) > 0) {
    echo '<ul>';
    foreach ($data['cms_pages_info'] as $value) {
?>
        <li>
            <a href="javascript:void(0);" class="btn-select-template <?php echo isset($data['id']) && $data['id'] == $value->id ? 'active' : ''; ?>" data-detail="<?php echo base64_encode(json_encode($value)); ?>">
                <b><?php echo $value->title; ?></b>
                <p class="d-none"><?php echo $value->slug; ?></p>
            </a>
        </li>
<?php
    }
    echo '</ul>';
}
?>