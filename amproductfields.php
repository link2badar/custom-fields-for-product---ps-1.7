<?php
/*
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2015 PrestaShop SA
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
/**
 * @author    Arnaud Merigeau <contact@arnaud-merigeau.fr>
 * @copyright  Copyright (c) 2009-2018 Arnaud Merigeau - https://www.arnaud-merigeau.fr
 * @license    You only can use module, nothing more!
 */

class AmProductFields extends Module {

	public function __construct() {
		$this->name = 'amproductfields';
        $this->tab = 'administration';
        $this->author = 'Arnaud Merigeau';
        $this->version = '1.0';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('(AM) Product Fields');
        $this->description = $this->l('Ajouter des champs supplémentaires aux produit');
        $this->ps_versions_compliancy = array('min' => '1.7.1', 'max' => _PS_VERSION_);
    }

    public function install() {
        if (!parent::install() || !$this->_installSql()
				|| !$this->registerHook('displayAdminProductsExtra')
                || !$this->registerHook('displayAdminProductsMainStepLeftColumnMiddle')
        ) {
            return false;
        }

        return true;
    }

    public function uninstall() {
        return parent::uninstall() && $this->_unInstallSql();
    }


	public function hookDisplayAdminProductsExtra($params)
    {

    }
    /**
     * Modifications sql du module
     * @return boolean
     */
    protected function _installSql() {
        $sqlInstall = "ALTER TABLE " . _DB_PREFIX_ . "product "
                . "ADD custom_field VARCHAR(255) NULL";
        $sqlInstallLang = "ALTER TABLE " . _DB_PREFIX_ . "product_lang "
                . "ADD custom_field_lang VARCHAR(255) NULL,"
                . "ADD custom_field_lang_wysiwyg TEXT NULL,"
                . "ADD is_figurine_require BOOLEAN NULL,"
				. "ADD allergens TEXT NULL";

        $returnSql = Db::getInstance()->execute($sqlInstall);
        $returnSqlLang = Db::getInstance()->execute($sqlInstallLang);

        return $returnSql && $returnSqlLang;
    }

    /**
     * Suppression des modification sql du module
     * @return boolean
     */
    protected function _unInstallSql() {
       $sqlInstall = "ALTER TABLE " . _DB_PREFIX_ . "product "
                . "DROP custom_field";
        $sqlInstallLang = "ALTER TABLE " . _DB_PREFIX_ . "product_lang "
                . "DROP custom_field_lang,DROP custom_field_lang_wysiwyg,DROP is_figurine_require,DROP allergens";

        $returnSql = Db::getInstance()->execute($sqlInstall);
        $returnSqlLang = Db::getInstance()->execute($sqlInstallLang);

        return $returnSql && $returnSqlLang;
    }

    /**
     * Affichage des informations supplémentaires sur la fiche produit
     * @param type $params
     * @return type
     */
    public function hookDisplayAdminProductsMainStepLeftColumnMiddle($params) {
        $product = new Product($params['id_product']);
        // print_r($product);die();
        $languages = Language::getLanguages(false);
        $this->context->smarty->assign(array(
            'custom_field' => $product->custom_field,
            'custom_field_lang' => $product->custom_field_lang,
            'custom_field_lang_wysiwyg' => $product->custom_field_lang_wysiwyg,
            'is_figurine_require' => $product->is_figurine_require,
			'allergens' => $product->allergens,

            'languages' => $languages,
            'default_language' => $this->context->employee->id_lang
            )
           );
        //   print_r($product->is_figurine_require);die();
        return $this->display(__FILE__, 'views/templates/hook/amproductfields.tpl');
    }
}
