<?php

class View {

	public function render($tpl, $data) {
		include ROOT. $tpl;
	}

}