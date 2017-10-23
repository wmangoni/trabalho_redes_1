<?php
namespace System;

class Router {

	private $url;

	public function getUrl() {
		return $this->url;
	}

	public function setUrl($url) {
		$this->url = $url;
	}
}