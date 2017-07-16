<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 16 July 2017, 10:47 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
/**
 * @var array $string
 * @var array $meta
 * @var array $data
 */
if (!isset($meta))
{
    $meta = [];
}
if (!isset($string))
{
    $string = [];
}
if (!isset($data))
{
    $data = [];
} ?>

<div id="update" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $string['profile_edit'] ?></h4>
            </div>
            <div class="row margin-top-20">
                <div class="col-xs-10 col-xs-offset-1">
                    <div id="form-message-container">
                    </div>
                </div>
            </div>
            <?php echo form_open('/api/profile/update', 'id="update_form"'); ?>
            <?php if (!empty(@$data['session']['redirector']))
            {
                echo form_hidden('redirector', $data['session']['redirector']);
            } ?>
            <div class="modal-body" id="modal-update">
                <div class="form-group">
                    <label class="control-label" for="<?php echo $string['inline_client_form_username_id'] ?>"><?php echo $string['client_form_username_label'] ?></label>
                    <input type="text" name="<?php echo $string['inline_client_form_username_id'] ?>" class="form-control" id="update_<?php echo $string['inline_client_form_username_id'] ?>" placeholder="<?php echo $string['client_form_username_placeholder'] ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="<?php echo $string['inline_client_form_email_id'] ?>"><?php echo $string['client_form_email_label'] ?></label>
                    <input type="text" name="<?php echo $string['inline_client_form_email_id'] ?>" class="form-control" id="update_<?php echo $string['inline_client_form_email_id'] ?>" placeholder="<?php echo $string['client_form_email_placeholder'] ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="<?php echo $string['inline_client_form_role_id'] ?>"><?php echo $string['client_form_role_label'] ?></label>
                    <input type="text" class="form-control" id="update_<?php echo $string['inline_client_form_role_id'] ?>" disabled>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="<?php echo $string['profile_edit'] ?>">
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
