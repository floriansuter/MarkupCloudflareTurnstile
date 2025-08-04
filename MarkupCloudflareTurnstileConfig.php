<?php namespace ProcessWire;

/**
 * Markup Cloudflare Turnstile Configuration
 *
 */

class MarkupCloudflareTurnstileConfig extends ModuleConfig {

	/**
	 * Returns default values for module variables
	 *
	 * @return array
	 *
	 */
	public function getDefaults() {
		return [
			'siteKey' => '',
			'secretKey' => '',
		];
	}

	/**
	 * Returns inputs for module configuration
	 *
	 * @return InputfieldWrapper
	 *
	 */
	public function getInputfields() {

		$inputfields = parent::getInputfields();

		$inputfields->add([
			'type' => 'text',
			'name' => 'siteKey',
			'label' => $this->_('Site Key'),
			'required' => true,
			'columnWidth' => 50,
			'icon' => 'key',
		]);

		$inputfields->add([
			'type' => 'text',
			'name' => 'secretKey',
			'label' => $this->_('Secret Key'),
			'required' => true,
			'columnWidth' => 50,
			'icon' => 'eye-slash',
			'attr' => [
				'type' => 'password',
				'autocomplete' => 'off',
			],
		]);

		$inputfields->add([
			'type' => 'select',
			'name' => 'dataTheme',
			'label' => $this->_('Theme'),
			'options' => [
				'auto' => $this->_('Auto'),
				'dark' => $this->_('Dark'),
				'light' => $this->_('Light'),
			],
			'value' => 'auto',
			'columnWidth' => 33,
			'icon' => 'paint-brush',
		]);

		$inputfields->add([
			'type' => 'select',
			'name' => 'dataSize',
			'label' => $this->_('Size'),
			'options' => [
				'normal' => $this->_('Normal'),
				'compact' => $this->_('Compact'),
			],
			'value' => 'normal',
			'columnWidth' => 34,
			'icon' => 'arrows-alt',
		]);

		$inputfields->add([
			'type' => 'text',
			'name' => 'dataIndex',
			'label' => $this->_('Tab Index'),
			'description' => $this->_('Set a tab index for the Turnstile widget. Leave empty for default behavior.'),
			'columnWidth' => 33,
			'icon' => 'indent',
			'value' => '',
			'required' => false,
		]);

		return $inputfields;
	}
}
