<?php
/**
 * Override Class ProductCore
 */
class Product extends ProductCore {

	public $custom_field;
	public $custom_field_lang;
	public $custom_field_lang_wysiwyg;
	public $is_figurine_require;
	public $allergens;

	public function __construct($id_product = null, $full = false, $id_lang = null, $id_shop = null, Context $context = null){

			self::$definition['fields']['custom_field'] = [
	            'type' => self::TYPE_STRING,
	            'required' => false, 'size' => 255
	        ];
	        self::$definition['fields']['custom_field_lang'] = [
	            'type' => self::TYPE_STRING,
	            'lang' => true,
	            'required' => false, 'size' => 255
	        ];
	        self::$definition['fields']['custom_field_lang_wysiwyg'] = [
	            'type' => self::TYPE_HTML,
	            'lang' => true,
	            'required' => false,
	            'validate' => 'isCleanHtml'
	        ];
	        self::$definition['fields']['is_figurine_require'] = [
	            'type' => self::TYPE_BOOL,
	            'lang' => true,
	            'required' => false,
	        ];
			self::$definition['fields']['allergens'] = [
			   'type' => self::TYPE_STRING,
			   'lang' => true,
			   'required' => false,
		   ];

	        parent::__construct($id_product, $full, $id_lang, $id_shop, $context);
	}
}
