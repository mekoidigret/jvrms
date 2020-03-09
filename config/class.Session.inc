<?php
	class Session {

		public function __construct() {
			session_start();
		}

		public function message($msg='', $mode='info') {
			if(!empty($msg)) {
				// Set
				$_SESSION['message']  = '<div id="message-pane" class="rounded alert alert-'.$mode.'">';
				$_SESSION['message'] .= $msg;
				$_SESSION['message'] .= '</div>';
				unset($msg);
			}
			else {
				if(isset($_SESSION['message'])) {
					// Get
					// $message  = '<div class="toast fade show" role="alert" aria-live="assertive" id="message-toast" aria-atomic="true">';
					// 	$message .= '<div class="toast-header">';
					// 		$message .= '<strong class="mr-auto">Message</strong>';
					// 		$message .= '<small>Just now</small>';
					// 		$message .= '<button class="ml-2 mb-1 close" aria-label="Close" type="button" data-target="#message-toast" data-dismiss="toast">';
					// 			$message .= '<span aria-hidden="true">×</span>';
					// 		$message .= '</button>';
					// 	$message .= '</div>';
					// 	$message .= '<div class="toast-body">';
					// 		$message .= $_SESSION['message'];
					// 	$message .= '</div>';
					// $message .= '</div>';
					$message = $_SESSION['message'];
					unset($_SESSION['message']);
					return $message;
				}
				else {
					return '';
				}
			}
		}

		public function login($user) {
			foreach($user as $key => $value) {
				$key = 'user_'.$key;
				$_SESSION[$key] = $value;
			}
			switch($user->access_level) {
				case Visitor::LEVEL:
					redirect('visitor');
					break;
				case Officer::LEVEL:
					redirect('officer');
					break;
				case Admin::LEVEL:
					redirect('admin');
					break;
			}
		}

		public function logout($message = '') {
			$this->check();
			foreach($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			if(!empty($message)) {
				$this->message($message, 'info');
			}
		}

		public function check($level = null) {
			if(!isset($_SESSION['user_id'])) {
				$this->message('Please login first.', 'warning');
				redirect('index.php');
			}
			else if($level != null && $_SESSION['user_access_level'] != $level) {
				$this->message('Access Denied.', 'danger');
				redirect('index.php');
			}
		}
	}
?>