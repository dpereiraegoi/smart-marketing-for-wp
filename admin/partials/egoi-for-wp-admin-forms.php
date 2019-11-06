<?
if ( ! defined( 'ABSPATH' ) ) die();

$dir = plugin_dir_path(__FILE__) . 'capture/';

include_once $dir . '/functions.php';
require_once plugin_dir_path(__FILE__) . 'egoi-for-wp-common.php';

$img = 'https://img.icons8.com/ios/50/000000/picture.png';

$home = '<svg class="smsnfCapture__header__menu__item__homeIcon" version="1.1" id="Camada_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30.3 27.1" style="enable-background:new 0 0 30.3 27.1;" xml:space="preserve"><style type="text/css">.st0{clip-path:url(#SVGID_4_);}.st1{clip-path:url(#SVGID_6_);}</style><g><g><path id="SVGID_1_" d="M1.2,16.1h2.4v9.8c0,0.6,0.5,1,1,1h7.2c0.6,0,1-0.5,1-1v-7.2h4.4v7.2c0,0.6,0.5,1,1,1H25c0.6,0,1-0.5,1-1v-9.8h3c0.4,0,0.8-0.3,1-0.6c0.2-0.4,0.1-0.8-0.2-1.1L16.2,0.6c-0.4-0.4-1.1-0.4-1.5,0L0.5,14.3c-0.3,0.3-0.4,0.8-0.2,1.2C0.4,15.8,0.8,16.1,1.2,16.1z M15.5,2.7L26.7,14h-1.5c-0.6,0-1,0.5-1,1v9.8h-4.7v-7.2c0-0.6-0.5-1-1-1H12c-0.6,0-1,0.5-1,1v7.2H5.9V15c0-0.6-0.5-1-1-1H4L15.5,2.7z"/></g><g><defs><path id="SVGID_2_" d="M1.2,16.1h2.4v9.8c0,0.6,0.5,1,1,1h7.2c0.6,0,1-0.5,1-1v-7.2h4.4v7.2c0,0.6,0.5,1,1,1H25c0.6,0,1-0.5,1-1v-9.8h3c0.4,0,0.8-0.3,1-0.6c0.2-0.4,0.1-0.8-0.2-1.1L16.2,0.6c-0.4-0.4-1.1-0.4-1.5,0L0.5,14.3c-0.3,0.3-0.4,0.8-0.2,1.2C0.4,15.8,0.8,16.1,1.2,16.1z M15.5,2.7L26.7,14h-1.5c-0.6,0-1,0.5-1,1v9.8h-4.7v-7.2c0-0.6-0.5-1-1-1H12c-0.6,0-1,0.5-1,1v7.2H5.9V15c0-0.6-0.5-1-1-1H4L15.5,2.7z"/></defs><clipPath id="SVGID_4_"><use xlink:href="#SVGID_2_"  style="overflow:visible;"/></clipPath><g class="st0"><g><rect id="SVGID_3_" x="-188.8" y="-134.9" width="1920" height="1080"/></g><g><defs><rect id="SVGID_5_" x="-188.8" y="-134.9" width="1920" height="1080"/></defs><clipPath id="SVGID_6_"><use xlink:href="#SVGID_5_"  style="overflow:visible;"/></clipPath><rect x="-4.8" y="-4.9" class="st1" width="40" height="36.8"/></g></g></g></g></svg>';

// apaga formulário avançado
if (isset($_GET['del_adv_form'])) {
    delete_option('egoi_form_sync_' . $_GET['del_adv_form']);
    echo get_notification('Formulário Avançado', 'O formulário foi apagado com sucesso.');
}

// apaga formulário simples
if (isset($_GET['del_simple_form'])) {
    delete_simple_form($_GET['del_simple_form']);
}

$page = array(
    'home' => !isset($_GET['sub']),
    'adv forms' => $_GET['sub'] == 'adv-forms',
    'simple form' => $_GET['sub'] == 'simple-forms',
    'subscription bar' => $_GET['sub'] == 'subscription-bar',
    'widget options' => $_GET['sub'] == 'widget-options',
);

$next_adv_form_id = get_next_adv_form_id();
?>


<!-- Wrap -->
<div class="smsnf">
    <div class="smsnf-modal-bg"></div>
    <!-- Header -->
    <header>
        <h1>Smart Marketing > <b><?=__('Capture Contacts', 'egoi-for-wp')?></b></h1>
        <nav>
            <ul>
                <li><a class="home <?= $page['home'] ?'-select':'' ?>" href="?page=egoi-4-wp-form"><?= $home ?></a></li>
                <li><a class="<?= $page['simple form'] ?'-select':'' ?>" href="?page=egoi-4-wp-form&sub=simple-forms"><? _e('Simple Forms', 'egoi-for-wp'); ?></a></li>
                <? // se $next_adv_form_id == null significa que já existem 5 adv forms logo o utilizador não pode criar mais formulários ?>
                <li><a class="<?= $page['adv forms'] ?'-select':'' ?> <?= $next_adv_form_id == null ?'-disabled':'' ?>"
                       href="<?= $next_adv_form_id == null ? "#" : "?page=egoi-4-wp-form&sub=adv-forms&form=" . $next_adv_form_id ?>"><? _e('Advanced Forms', 'egoi-for-wp'); ?></a></li>
                <li><a class="<?= $page['subscription bar'] ?'-select':'' ?>" href="?page=egoi-4-wp-form&sub=subscription-bar"><? _e('Subscriber Bar', 'egoi-for-wp'); ?></a></li>
                <li><a class="<?= $page['widget options'] ?'-select':'' ?>" href="?page=egoi-4-wp-form&sub=widget-options"><? _e('Widget Options', 'egoi-for-wp'); ?></a></li>
            </ul>
        </nav>
    </header>
    <!-- / Header -->
    <!-- Content -->
    <main>
        <!-- Content -->
        <section class="smsnf-content">
            <?
            if ($page['home']) {
                $file = $dir . 'home.php';
            } elseif($page['simple form']) {
                $file = $dir . 'simple-forms.php';
            } elseif ($page['adv forms']) {
                $file = $dir . 'advanced-forms.php';
            } elseif($page['subscription bar']) {
                $file = $dir . 'subscription-bar.php';
            } elseif($page['widget options']) {
                $file = $dir . 'widget-options.php';
            }

            include($file);
            ?>
            <? if ($page['simple form'] || $page['subscription bar'] || $page['widget options']) : ?>
                <div class="modal" id="create-new-tag">
                    <a href="#close" class="modal-overlay" aria-label="Close"></a>
                    <div class="modal-container">
                        <div class="modal-header">
                            <a href="#close" class="btn btn-clear float-right" aria-label="Close"></a>
                            <h2>Criar Nova tag</h2>
                        </div>
                        <div class="modal-body">
                            <div class="content">
                                <form id="new_tag_form" class="new_tag_form">
                                    <div class="smsnf-input-group">
                                        <label for="tag_name">Nome</label>
                                        <input id="new_tag_name" type="text" name="name" />
                                    </div>
                                    <div class="smsnf-input-group">
                                        <input id="new_tag_submit" type="submit" value="Criar TAG">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <? endif; ?>
        </section>
        <!-- / Content -->
        <!-- Pub -->
        <section class="smsnf-pub">
            <div>
                <?php include ('egoi-for-wp-admin-banner.php'); ?>
            </div>
        </section>
        <!-- / Pub -->
    </main>
    <!-- / Content -->
</div>
<!-- / Wrap -->
