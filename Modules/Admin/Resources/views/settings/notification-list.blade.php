<?php
if (isset($data['email_templates_info']) && count($data['email_templates_info']) > 0) {
    echo '<ul>';
    foreach ($data['email_templates_info'] as $value) {
?>
        <li>
            <a href="javascript:void(0);" class="btn-select-template <?php echo isset($data['id']) && $data['id'] == $value->id ? 'active' : ''; ?>" data-detail="<?php echo base64_encode(json_encode($value)); ?>">
                <b><?php echo $value->subject; ?></b>
                <p><?php echo $value->description; ?></p>
            </a>
        </li>
<?php
    }
    echo '</ul>';
}
?>