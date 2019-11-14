<?php
if (isset($_POST['id_simple_form'])) {

    function saveSimpleForm() {
        global $wpdb;

        $table = $wpdb->prefix.'posts';
        $user = wp_get_current_user();
        $date = date('Y-m-d H:i:s');
        $post_name =  preg_replace('~[^0-9a-z]+~i', '-', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities(str_replace(" ", "-", strtolower($_POST['title'])), ENT_QUOTES, 'UTF-8'))) ;


        //to save simple form options: listId and language
        $table2 = $wpdb->prefix.'options';

        $data->list = $_POST['list'];
        $data->lang = $_POST['lang'];
        $data->double_optin = $_POST['double_optin'];

        //to add tag if not exist
        if(isset($_POST['tag-egoi']) && $_POST['tag-egoi']!=''){
            $data->tag = $_POST['tag-egoi'];
        }
        else{
            $tag = new Egoi_For_Wp();
            $new = $tag->addTag($_POST['tag']);
            $data->tag = $new->ID;
        }

        $info = json_encode($data);

        if ($_POST['id_simple_form'] == 0) {
            $post = array (
                'post_author' => $user->ID,
                'post_date' => $date,
                'post_date_gmt' => $date,
                'post_content' => $_POST['html_code'],
                'post_title' => $_POST['title'],
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_name' => $post_name,
                'post_modified' => $date,
                'post_modified_gmt' => $date,
                'guid' => $_SERVER['HTTP_REFERER'],
                'post_type' => 'egoi-simple-form'
            );

            $query =  $wpdb->insert($table, $post);
            $id_simple_form = $wpdb->insert_id;

            //insert simple form options
            $options = array(
                'option_name' => 'egoi_simple_form_'.$id_simple_form,
                'option_value' => $info,
                'autoload' => 'yes'
            );

            $query2 =  $wpdb->insert($table2, $options);

        }
        else {

            $post = array (
                'post_author' => $user->ID,
                'post_content' => $_POST['html_code'],
                'post_title' => $_POST['title'],
                'post_name' => $post_name,
                'post_modified' => $date,
                'post_modified_gmt' => $date,
                'guid' => $_SERVER['HTTP_REFERER']
            );

            $where = array('ID' => $_POST['id_simple_form']);
            $query = $wpdb->update($table, $post, $where);
            $id_simple_form = $_POST['id_simple_form'];

            //update simple form options
            $options = array(
                'option_value' => $info
            );

            $where2 = array('option_name' => 'egoi_simple_form_'.$id_simple_form);

            $query2 = $wpdb->update($table2, $options, $where2);
        }

        $shortcode = '[egoi-simple-form id="'.$id_simple_form.'"]';

        return array(
            'shortcode' => $shortcode,
            'id_simple_form' => $id_simple_form,
            'title_simple_form' => $_POST['title'],
            'html_code_simple_form' => $_POST['html_code'],
            'list' => $_POST['list'],
            'lang' => $_POST['lang'],
            'tag' => isset($_POST['tag-egoi']) ? $_POST['tag-egoi'] : $new->ID,
            'double_optin' => $_POST['double_optin']
        ) ;

    }

    $shortcode = saveSimpleForm();
    $id_simple_form = $shortcode['id_simple_form'];
    echo get_notification(__('Saved Form', 'egoi-for-wp'), __('Form saved with success.', 'egoi-for-wp'));

} else if (isset($_GET['edit_simple_form'])) {

    function selectSimpleForm($id) {
        global $wpdb;
        $table = $wpdb->prefix."posts";
        $shortcode['shortcode'] = '[egoi-simple-form id="'.$id.'"]';
        $shortcode['title_simple_form'] = $wpdb->get_var( "SELECT post_title FROM ".$table." WHERE ID = '".$id."' " );
        $shortcode['html_code_simple_form'] = $wpdb->get_var( "SELECT post_content FROM ".$table." WHERE ID = '".$id."' " );


        //get simple form options
        $data = get_option('egoi_simple_form_'.$id);

        $info = json_decode($data);

        $shortcode['list'] = $info->list;
        $shortcode['lang'] = $info->lang;
        $shortcode['tag'] = $info->tag;
        $shortcode['double_optin'] = $info->double_optin;

        return $shortcode;
    }

    $shortcode = selectSimpleForm($_GET['form']);
    $id_simple_form = $_GET['form'];

} else {
    $id_simple_form = 0;
}
?>

<form id="smsnf-simple-forms-form" method="post" action="#">
    <div class="smsnf-grid">
        <div>
            <input name="action" type="hidden" value="1" />
            <input name="id_simple_form" type="hidden" value="<?=$id_simple_form?>" />
            <!-- Double Opt-In -->
            <div class="smsnf-input-group">
                <label for="sf_double_optin"><?php _e( 'Enable Double Opt-In?', 'egoi-for-wp' ); ?></label>
                <p class="subtitle"><?php _e( 'If you activate the double opt-in, a confirmation e-mail will be send to the subscribers.', 'egoi-for-wp' ); ?></p>
                <div class="form-group switch-yes-no">
                    <label class="form-switch">
                        <?php $double_optin_enable = !isset($shortcode['double_optin']) || $shortcode['double_optin'] == 1 ?>
                        <input id="sf_double_optin" name="double_optin" value="1" <?php checked($double_optin_enable, 1); ?> type="checkbox">
                        <i class="form-icon"></i><div class="yes"><?php _e( 'Yes' ); ?></div><div class="no"><?php _e( 'No' ); ?></div>
                    </label>
                </div>
            </div>
            <!-- / Double Opt-In -->
            <!-- LISTAS -->
            <?php get_list_html($shortcode['list'], 'list') ?>
            <!-- / LISTAS -->
            <!-- lang -->
            <?php get_lang_html($shortcode['lang'], 'lang', empty($shortcode['list'])) ?>
            <!-- / lang -->
            <!-- TAGS -->
            <!-- / TAGS -->
            <!-- TÍTULO -->
            <div class="smsnf-input-group">
                <label for="form_name"><?php _e('Form title', 'egoi-for-wp'); ?></label>
                <input  id="form_name" type="text"
                    name="title" size="30" spellcheck="true" autocomplete="off" pattern="\S.*\S"
                    value="<?= htmlentities(stripslashes($shortcode['title_simple_form'])) ?>"
                    placeholder="<?= __( "Write here the title of your form", 'egoi-for-wp' ); ?>" />
            </div>
            <!-- / TÍTULO -->
            <!-- CÓDIGO HTML -->
            <div class="smsnf-input-group">
            <?php $content = stripslashes($shortcode['html_code_simple_form']) ?>
                <label for="sf-code"><?php _e('HTML code', 'egoi-for-wp'); ?></label>
                <div id="sf-btns" class="smsnf-btn-group">
                    <button id="sf-btn-name" class="smsnf-btn <?= strpos($content, '[e_name]') || strpos($content, '[/e_name]') ? 'active' : '' ?>" type="button" data-lable="<?= _e('Name', 'egoi-for-wp') ?>"><?php _e('Name', 'egoi-for-wp');?></button>
                    <button id="sf-btn-email" class="smsnf-btn <?= strpos($content, '[e_email]') || strpos($content, '[/e_email]') ? 'active' : '' ?>" type="button" data-lable="<?= _e('Email', 'egoi-for-wp') ?>"><?php _e('Email', 'egoi-for-wp');?></button>
                    <button id="sf-btn-phone" class="smsnf-btn <?= strpos($content, '[e_mobile]') || strpos($content, '[/e_mobile]') ? 'active' : '' ?>" type="button" data-lable="<?= _e('Mobile', 'egoi-for-wp') ?>"><?php _e('Mobile', 'egoi-for-wp');?></button>
                    <button id="sf-btn-submit" class="smsnf-btn <?= strpos($content, '[e_submit]') || strpos($content, '[/e_submit]') ? 'active' : '' ?>" type="button" data-lable="<?= _e('Submit Button', 'egoi-for-wp') ?>"><?php _e('Submit Button', 'egoi-for-wp');?></button>
                </div>
                <textarea id="sf-code" rows="11" name="html_code" placeholder="<?= _e( 'HTML code of your form', 'egoi-for-wp' ); ?>"><?=$content?></textarea>
            </div>
            <!-- / CÓDIGO HTML -->

            <div class="smsnf-input-group">
                <input type="submit" value="<?php _e('Save', 'egoi-for-wp');?>" />
            </div>
        </div>
        <div>
            <?php if ($id_simple_form != 0) : ?>
                <!-- SHORTCODE -->
                <div class="smsnf-input-group">
                        <label for="smsnf-af-shortcode">Shortcode</label>
                        <div
                            class="tooltip shortcode -copy"
                            type="text"
                            data-clipboard-text="<?= esc_html('[egoi-simple-form id="' . $id_simple_form . '"]') ?>"
                            data-before="<?php _e('Click to copy', 'egoi-for-wp');?>"
                            data-after="<?php _e('Copied', 'egoi-for-wp');?>"
                            data-tooltip="<?php _e('Click to copy', 'egoi-for-wp');?>"
                            ><?= esc_html('[egoi-simple-form id="' . $id_simple_form . '"]') ?></div>
                        <p class="subtitle"><?php _e('Use this shortcode to display this form inside of your site or blog', 'egoi-for-wp');?></p>
                    </div>
                    <!-- / SHORTCODE -->
            <?php endif; ?>
        </div>
    </div>
</form>