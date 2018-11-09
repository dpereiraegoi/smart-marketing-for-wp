<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die();
}
/**
*  E-goi Listener 4 Syncronize Users with WP
*/
class Egoi_For_Wp_Listener {
	
	private $options_listen = '';
	private $user = '';
	private $enabled = '';

	public function __construct( $plugin_name, $version ){

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function init($user_id){

		if ($this->isActive()){
			if($user_id){
				$this->Listen($user_id);
			}
		}

	}

	public function isActive(){

		$options = get_option(Egoi_For_Wp_Admin::OPTION_NAME);
		$this->options_listen = $options;

		if($options['enabled']){
			$this->enabled = $options['enabled'];
			return $this->enabled;
		}

	}

	private function getMapping($user_id){

		global $wpdb;
		
		$table = $wpdb->prefix."egoi_map_fields";
		$sql="SELECT * FROM $table order by id DESC";
        $rows = $wpdb->get_results($sql);

        return $rows;
	}

	private function Listen($user_id){

		$user = get_userdata($user_id);

		$list = $this->options_listen['list'];

		$admin = new Egoi_For_Wp($this->plugin_name, $this->version);
		
		//mapping fields
		if(get_option('egoi_mapping')){
			
			$op = 1;
			$ref_fields = array();
			$all_fields = get_user_meta($user_id);
			$all_fields['user_email'][0] = $user->user_email;
			$all_fields['user_url'][0] = $user->user_url;
			$all_fields['user_login'][0] = $user->user_login;
			foreach ($all_fields as $key => $value) {
				$row = $admin->getFieldMap(0, $key);

				if($row){
					$fields[$row] = $value[0];
				}
			}
		}

		$role = $this->options_listen['role'];
		if (isset($_POST['billing_first_name']) && isset($_POST['billing_last_name'])) {
            $name = $_POST['billing_first_name'].' '.$_POST['billing_last_name'];
        } else {
            $name = $user->display_name;
        }
		$email = $user->user_email;

		if (isset($_POST['billing_phone']) && !isset($ref_fields['tel'])) {
            $ref_fields['tel'] = $_POST['billing_phone'];
        }

        if (isset($_POST['billing_cellphone']) && !isset($ref_fields['cell'])) {
            $ref_fields['cell'] = $_POST['billing_cellphone'];
        }

        // micro integration with woocommerce checkout fields brazil plugin
        if (is_plugin_active('woocommerce-extra-checkout-fields-for-brazil/woocommerce-extra-checkout-fields-for-brazil.php')) {

            preg_match('#\((.*?)\)#', $_POST['billing_phone'], $match_phone);
            if (isset($match_phone[1])) {
                $ref_fields['tel'] = '55-'.preg_replace('/[^0-9]/', '', $_POST['billing_phone']);
            }

            preg_match('#\((.*?)\)#', $_POST['billing_cellphone'], $match_cellphone);
            if (isset($match_cellphone[1])) {
                $ref_fields['cell'] = '55-'.preg_replace('/[^0-9]/', '', $_POST['billing_cellphone']);
            }

        }

		if($role == $user->roles[0]){
			
			$addtags = $admin->addTag($user->roles[0]);
			if(!$addtags->ERROR){
				$tag_id = $addtags->ID;
				$admin->addSubscriberTags($list, $email, array($tag_id), $name, '', $role, $fields, $op, $ref_fields);

			}else{
				$get_tags = $admin->getTags(1);
				if (!empty($get_tags)) {
					foreach($get_tags->TAG_LIST as $key => $tag){
						if(in_array(strtolower($user->roles[0]), (array)$tag)){
							$admin->addSubscriberTags($list, $email, array($tag->ID), $name, '', $role, $fields, $op, $ref_fields);
						}
					}
				}
			}
		}else{
			$admin->addSubscriberTags($list, $email, array(''), $name, '', false, $fields, $op, $ref_fields);
		}
			
	}

	public function Listen_update($user_id) {

		if ($this->isActive()){
			$user = get_userdata($user_id);
			$role = $user->roles[0];
			$email = $user->user_email;
			$fname = ucfirst($user->display_name);

			$list = $this->options_listen['list'];
			
			$admin = new Egoi_For_Wp($this->plugin_name, $this->version);

			//mapping fields
			if(get_option('egoi_mapping')){
				
				$op = 1;
				$all_fields = get_user_meta($user_id);
				$all_fields['user_email'][0] = $email;
				$all_fields['user_url'][0] = $user->user_url;
				$all_fields['user_login'][0] = $user->user_login;
				foreach ($all_fields as $key => $value) {
					$row = $admin->getFieldMap(0, $key);

					if($row){
						$fields[$row] = $value[0];
					}
				}

			}

			$get_user = $admin->editSubscriber($list, $email, $role, $fname, '', $fields, $op);
			if($get_user->ERROR == 'SUBSCRIBER_NOT_FOUND'){
				$admin->addSubscriber($list, $user->user_login, $user->user_email, $fields);
			}

		}

	}

	public function Listen_delete($user_id) {

		if ($this->isActive()){
			$user = get_userdata($user_id);
			$list = $this->options_listen['list'];

			$admin = new Egoi_For_Wp($this->plugin_name, $this->version);
			$del_user = $admin->delSubscriber($list, $user->user_email);

			if($del_user->ERROR == 'SUBSCRIBER_NOT_FOUND'){
				return false;
			}
		}

	}

}