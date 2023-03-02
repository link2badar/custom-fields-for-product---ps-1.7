# custom-fields-for-product---ps-1.7
plugin for adding custom fields to product page in admin panel. prestashop 1.7 custom fields

step1: 
Just install the plugin in admin panel

step2:
Go to product page. 
e.g. themes/classic/templates/catalog/product.tpl

step3:
variables will be available on the product detail page.
{$product.custom_field}
{$product.allergens nofilter}
{$product.custom_field_lang}
{$product.custom_field_lang_wysiwyg}
{$product.is_figurine_require}

Step4:
Clear your cache from the admin panel and from the browser too.

Step 5:
enjoy!
