<?php namespace ProcessWire;

/**
 * Markup Cloudflare Turnstile
 *
 * @copyright 2025 NB Communication Ltd
 * @license Mozilla Public License v2.0 http://mozilla.org/MPL/2.0/
 *
 */

class MarkupCloudflareTurnstile extends WireData implements Module, ConfigurableModule {

	/**
	 * Render
	 *
	 * @param array $attrs
	 * @param InputfieldForm $form
	 * @return string
	 *
	 */
	public function render($attrs = [], InputfieldForm $form = null) {

		if($attrs instanceof InputfieldForm) {
			$form = $attrs;
			$attrs = [];
		}

		if(!is_array($attrs)) $attrs = [];

		$attrs = array_merge($attrs, [
			'data-sitekey' => $this->siteKey,
			'data-theme' => $this->dataTheme,
			'data-size' => $this->dataSize,
			'data-tabindex' => $this->dataIndex
		]);

		if(!isset($attrs['class'])) {
			$attrs['class'] = 'cf-turnstile';
		}

		$attrsStr = '';
		foreach($attrs as $key => $value) {
			if(is_array($value)) $value = implode(' ', $value);
			if(is_object($value)) $value = (string) $value;
			$attrsStr .= is_bool($value) ? " $key" : " $key=\"$value\"";
		}

		$out = "<div $attrsStr></div>";

		if($form) {
			$form->add([
				'type' => 'markup',
				'name' => 'cf-turnstile',
				'value' => $out,
			]);
			return $form;
		}

		return $out;
	}

	/**
	 * Get the Cloudflare Turnstile Client API script
	 *
	 * @param array $params
	 * @return string
	 *
	 */
	public function getScript(array $params = []) {
		$url = 'https://challenges.cloudflare.com/turnstile/v0/api.js';
		if(count($params)) $url .= '?' . http_build_query($params);
		return "<script src=\"$url\" defer></script>";
	}

	/**
	 * Verify the response
	 *
	 * @return bool
	 *
	 */
	public function verifyResponse($response = null) {

		// check if $response->value is set
		if ($response instanceof WireInput) {
			$response = $response->post('cf-turnstile-response');
		} elseif ($response instanceof WireData) {
			$response = $response->get('cf-turnstile-response');
		} elseif ($response === null) {
			// If no response is provided, try to get it from the request
			$response = $this->wire('input')->post('cf-turnstile-response');
		}

		if(!$response || $response === "") return false;

		return json_decode($this->wire(new WireHttp())->post(
			'https://challenges.cloudflare.com/turnstile/v0/siteverify',
			[
				'secret' => $this->secretKey,
				'response' => $response,
			],
			[
				'use' => 'curl',
			]
		), true)['success'] ?? false;
	}
}
