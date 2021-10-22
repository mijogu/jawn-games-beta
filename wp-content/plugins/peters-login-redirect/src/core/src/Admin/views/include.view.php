<?php

use LoginWP\Core\Admin\RedirectWPList;
use LoginWP\Core\Helpers;

$ruleData = [];

if (isset($_GET['id'])) {
    $ruleData = Helpers::get_rule_by_id(absint($_GET['id']));
}

add_action('add_meta_boxes', function () use ($ruleData) {
    add_meta_box(
        'ptr-loginwp-redirection-rule-condition',
        esc_html__('Rule Condition', 'peters-login-redirect'),
        function () use ($ruleData) {
            require dirname(__FILE__) . '/view.condition-rule.php';
        },
        'ptrloginwpredirection'
    );
});

add_action('add_meta_boxes', function () use ($ruleData) {
    add_meta_box(
        'ptr-loginwp-redirection-rule-urls',
        esc_html__('Redirect URLs', 'peters-login-redirect'),
        function () use ($ruleData) {
            require dirname(__FILE__) . '/view.redirect-urls.php';
        },
        'ptrloginwpredirection'
    );
});

do_action('add_meta_boxes', 'ptrloginwpredirection', '');

?>
<div style="padding-top: 0">
    <div id="post-body" class="metabox-holder">

        <div class="loginwp-rule-actions-wrap">

            <div class="loginwp-delete-action">
                <?php if (isset($_GET['action']) && 'edit' == $_GET['action']) : ?>
                    <a class="loginwp-delete-prompt" href="<?php echo esc_url(RedirectWPList::delete_rule_url(absint($_GET['id']))); ?>"><?= esc_html__('Delete', 'peters-login-redirect') ?></a>
                <?php endif; ?>
            </div>

            <div class="loginwp-save-action">
                <?php wp_nonce_field('loginwp_save_rule', 'rul-loginwp-nonce') ?>
                <input style="min-height: 35px;padding: 0 15px;" type="submit" name="loginwp_save_rule" class="button button-primary button-large" value="<?= esc_html__('Save Rule', 'peters-login-redirect') ?>">
            </div>
            <div class="clear"></div>
        </div>

        <div id="postbox-container-1" class="postbox-container">
            <?php do_meta_boxes('ptrloginwpredirection', 'sidebar', ''); ?>
        </div>
        <div id="postbox-container-2" class="postbox-container">
            <?php do_meta_boxes('ptrloginwpredirection', 'advanced', ''); ?>
        </div>
    </div>
    <br class="clear">
</div>