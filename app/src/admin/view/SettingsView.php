<?php

namespace view;

class SettingsView {

	/**
	 * @var string
	 */
	private $message = "";

	/**
	 * @var string
	 */
	private $titleMsg = "";

	/**
	 * @return string
	 */
	public function getSettings() {
		$blogTitle = \common\Config::get("blogTitle");
		$footerText = \common\Config::get("blogFooter");

		return "<div class='adminContent'>
					<div class='settings'>
						<h2><span class='glyphicon glyphicon-cog'></span> Settings</h2>
						$this->message
						<div class='settings-inner'>
						<form method='post'>

							<div class='form-group'>
								<label class='control-label'>Blog Title</label>
							 	<div class='controls'>
							 		$this->titleMsg
							 		<input class='form-control' type='text' name='blogTitle' value='$blogTitle' >
							 	</div>
							</div>
							<div class='form-group'>
								<label class='control-label'>Footer Text</label>
							 	<div class='controls'>
							 		<input class='form-control' type='text' name='footerText' value='$footerText' >
							 	</div>
							</div>

							<input class='btn btn-primary' type='submit' name='saveSetting' value='Save'>
						</form>
						SettingsView:: Ej hunnit implementera felhantering
						</div>
					</div>
				</div>";
	}

	public function saveFail() {
		if (strlen($this->getBlogName()) < 1) {
			$this->titleMsg = "<span class='error'>Blog Title can not be empty.</span>";
		}
	}

	public function saveSuccsses() {
		$this->message = "<div class='alert alert-success'>Successfully updated your settings!</div>";
	}

	/**
	 * @return boolian
	 */
	public function isSubmitted() {
		return isset($_POST["saveSetting"]);
	}

	/**
	 * @return string
	 */
	public function getBlogName() {
		return $_POST["blogTitle"];
	}

	/**
	 * @return string
	 */
	public function getFooterText() {
		return $_POST["footerText"];
	}
}