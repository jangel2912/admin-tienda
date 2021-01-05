<?php

Route::get('test', function () {
    $dns = collect(dns_get_record('mascotikas.com'));

    dd($dns->where('type', 'A')->where('ip', '52.89.132.202')->first());
});

// METODOS DE PAGO
Route::group([
    'middleware' => 'tenant',
    'prefix' => 'payments',
], function() {
    // WOMPI
    Route::get('wompi', 'User\PaymentMethod\WompiController@index')->name('settings.payments.getwompi');
    Route::post('wompi', 'User\PaymentMethod\WompiController@update')->name('settings.payments.setwompi');

    // EPAYCO
    Route::get('epayco', 'User\PaymentMethod\EPaycoController@index')->name('settings.payments.getepayco');
    Route::post('epayco', 'User\PaymentMethod\EPaycoController@update')->name('settings.payments.setepayco');

    // // PAYU
    Route::get('payu', 'User\PaymentMethod\PayUController@index')->name('settings.payments.getpayu');
    Route::post('payu', 'User\PaymentMethod\PayUController@update')->name('settings.payments.setpayu');

    // // MERCADOPAGO
    Route::get('mercadopago', 'User\PaymentMethod\MercadoPagoController@index')->name('settings.payments.getmercadopago');
    Route::post('mercadopago', 'User\PaymentMethod\MercadoPagoController@update')->name('settings.payments.setmercadopago');

    // // OPENPAY
    // Route::get('openpay', 'User\PaymentMethod\OpenPayController@index')->name('settings.payments.getopenpay');
    // Route::post('openpay', 'User\PaymentMethod\OpenPayController@update')->name('settings.payments.setopenpay');

    // // PAYPAL
    Route::get('paypal', 'User\PaymentMethod\PayPalController@index')->name('settings.payments.getpaypal');
    Route::post('paypal', 'User\PaymentMethod\PayPalController@update')->name('settings.payments.setpaypal');

    // EFECTIVO
    Route::get('cash', 'User\PaymentMethod\CashController@index')->name('settings.payments.getcash');
    Route::post('cash', 'User\PaymentMethod\CashController@update')->name('settings.payments.setcash');

    //KUSHKI
    Route::get('kushki', 'User\PaymentMethod\KushkiController@index')->name('settings.payments.getkushki');
    Route::post('kushki', 'User\PaymentMethod\KushkiController@update')->name('settings.payments.setkushki');

    //PAYMENTEZ
    Route::get('paymentez', 'User\PaymentMethod\PaymentezController@index')->name('settings.payments.getpaymentez');
    Route::post('paymentez', 'User\PaymentMethod\PaymentezController@update')->name('settings.payments.setpaymentez');
});

Route::group([
	'middleware' => ['activeshop', 'tenant']
], function() {
	Route::get('dashboard', 'User\DashboardController@index')->name('dashboard');
	Route::get('dashboard/chart', 'User\DashboardController@chart')->name('dashboard.chart');
	Route::post('dashboard/update_data', 'User\DashboardController@updateData')->name('dashboard.updateData');

	// CONFIGURACIóN DE LA TIENDA
	Route::group([
		'prefix' => 'settings'
	], function() {
		// INFORMACIÓN BASICA
		Route::get('basic', 'User\SettingsController@getBasic')->name('settings.getbasic');
		Route::post('basic', 'User\SettingsController@setBasic')->name('settings.setbasic');
		Route::get('qrcodepdf', 'User\SettingsController@getQrcodePdf')->name('settings.getqrcodepdf');
		Route::get('downloadqr', 'User\SettingsController@downloadQrCode')->name('settings.downloadqr');
        
        //LOGOS
        Route::get('logo', 'User\SettingsController@getLogo')->name('settings.getlogo');

        // DOMAINS
        Route::get('domains', 'User\SettingsController@getDomains')->name('settings.getdomains');
		Route::post('domains', 'User\SettingsController@setDomains')->name('settings.setdomains');

		// SLIDERS
		Route::get('sliders', 'User\SettingsController@getSliders')->name('settings.getsliders');

		// SEO
		Route::get('seo', 'User\SettingsController@getSeo')->name('settings.getseo');
		Route::post('seo', 'User\SettingsController@setSeo')->name('settings.setseo');

		// ENVIO
		Route::get('shipping', 'User\ShippingController@index')->name('settings.getshipping');
		Route::post('shipping', 'User\ShippingController@update')->name('settings.setshipping');
        Route::post('set-shipping-by-destination', 'User\ShippingController@setShippingByDestination')->name('settings.setshippingbydestination');
        Route::get('download', 'User\ShippingController@download')->name('shipping.download');
        Route::get('delete', 'User\ShippingController@delete')->name('shipping.delete');

		// CHAT
		Route::get('script-chat', 'User\SettingsController@getScriptChat')->name('settings.getscriptchat');
        Route::post('script-chat', 'User\SettingsController@setScriptChat')->name('settings.setscriptchat');

		// METAS
		//Route::get('goals', 'User\SettingsController@getGoals')->name('settings.getgoals');
        //Route::post('goals', 'User\SettingsController@setGoals')->name('settings.setgoals');
		

        // PLANTILLAS
        Route::get('templates', 'User\SettingsController@getTemplates')->name('settings.gettemplates');

        // HORARIOS
        Route::get('schedule', 'User\SettingsController@getSchedule')->name('settings.getschedule');
        Route::get('schedule/{id}', 'User\SettingsController@getSingleSchedule')->name('settings.getsingleschedule');
        Route::post('schedule', 'User\SettingsController@setSchedule')->name('settings.setschedule');
        Route::delete('schedule/{id}', 'User\SettingsController@removeSchedule')->name('settings.removeschedule');
	});

	Route::group([
	    'prefix' => 'info'
    ], function () {
        // NOSOTROS
        Route::get('about-us', 'User\InfoController@getAboutus')->name('info.getaboutus');
        Route::post('about-us', 'User\InfoController@setAboutus')->name('info.setaboutus');

        // CONTACTANOS
        Route::get('contact-us', 'User\InfoController@getContactus')->name('info.getcontactus');
        Route::post('contact-us', 'User\InfoController@setContactus')->name('info.setcontactus');

		// TERMINOS Y CONDICIONES
		Route::get('social-networks', 'User\InfoController@getSocialNetworks')->name('info.getsocialnetworks');
		Route::post('social-networks', 'User\InfoController@setSocialNetworks')->name('info.setsocialnetworks');

        // REDES SOCIALES
        Route::get('terms', 'User\InfoController@getTerms')->name('info.getterms');
        Route::post('terms', 'User\InfoController@setTerms')->name('info.setterms');
    });

	// CLIENTES
	Route::get('customers', 'User\CustomersController@index')->name('customers');
    Route::get('prices', 'User\PricesController@index')->name('prices');
    Route::get('customers/download', 'User\CustomersController@download')->name('customers.download');

	// PEDIDOS
	Route::get('orders', 'User\OrdersController@index')->name('orders');
    Route::get('orders/download', 'User\OrdersController@download')->name('orders.download');
    Route::get('order/{id}', 'User\OrdersController@detailsSale')->name('order');

	// PRODUCTOS
    Route::get('products/create-with-attributes', 'User\ProductsController@createWithAttributes')->name('products.createWithAttributes');
    Route::post('products/store-with-attributes', 'User\ProductsController@storeWithAttributes')->name('products.storeWithAttributes');
    Route::get('products/{product}/edit-with-attributes', 'User\ProductsController@editWithAttributes')->name('products.editWithAttributes');
    Route::put('products/{product}/update-with-attributes', 'User\ProductsController@updateWithAttributes')->name('products.updateWithAttributes');
    Route::post('products/delete-image', 'User\ProductsController@deleteImage')->name('products.deleteImage');
    Route::post('products/check', 'User\ProductsController@check')->name('products.check');
    Route::put('products/{product}/featured', 'User\ProductsController@featured')->name('products.featured');
    Route::put('products/sell-all-without-stock', 'User\ProductsController@sellAllWithoutStock')->name('products.sellallwithoutstock');
    Route::put('products/sell-all-only-withStock', 'User\ProductsController@sellAllOnlyWithStock')->name('products.sellallonlywithStock');
    Route::put('products/show-stock-of-all-products', 'User\ProductsController@showStockOfAllProducts')->name('products.showstock');
    Route::put('products/hide-stock-of-all-products', 'User\ProductsController@hideStockOfAllProducts')->name('products.hidestock');
    Route::get('products/upload-from-excel', 'User\ProductsController@uploadFromExcel')->name('products.upload.excel');
    Route::post('products/validate-excel', 'User\ProductsController@validateExcel')->name('products.validate.excel');
    Route::get('products/upload-from-excel/download', 'User\ProductsController@download')->name('products.download.excel');
    Route::get('product/upload-from-excel/download-with-attributes', 'User\ProductsController@downloadWithAttributes')->name('products.downloadWithAttributes.excel');
    Route::resource('products', 'User\ProductsController');

    // AJAX PRODUCTOS
    Route::post('product/all-ajax', 'User\ProductsController@ajaxGetProducts');

    // PROMOCIONES
    Route::resource('promotions', 'User\PromotionController');
    Route::post('promotions/{promotion}/activate', 'User\PromotionController@activate')->name('promotions.activate');
    Route::post('promotions/{promotion}/deactivate', 'User\PromotionController@deactivate')->name('promotions.deactivate');
    Route::post('product/all-ajax/promotion/{promotion}', 'User\PromotionController@ajaxGetProducts');
    Route::post('description/all-ajax/promotion/{promotion}', 'User\PromotionController@ajaxGetDescriptions');

    Route::resource('categories', 'User\CategoriesController');

    //CUPONES
    Route::resource('coupons', 'User\CouponsController');
});

// CAMBIAR PLANTILLA
Route::post('templates', 'User\SettingsController@setTemplates')->name('changeTemplate');
// SUBIR IMAGENES
Route::post('upload-image', 'User\SettingsController@uploadImage')->name('uploadImage');
Route::post('upload-favicon', 'User\SettingsController@uploadFaviconImage')->name('uploadFavicon');
// ELIMINAR IMAGENES
Route::post('delete-image', 'User\SettingsController@deleteImage')->name('deleteImage');

// WIZARD
Route::group([
	'prefix' => 'wizard',
    'as' => 'wizard.',
    'middleware' => ['not-activeshop', 'tenant']
], function() {

	// STEP 1
    Route::get('step-1', 'User\Wizard\FirstStepController@create')->name('firststep.create');
    Route::post('step-1', 'User\Wizard\FirstStepController@store')->name('firststep.store');

	// STEP 2
    Route::get('step-2', 'User\Wizard\SecondStepController@create')->name('secondstep.create');

	// STEP 3
    Route::get('step-3', 'User\Wizard\ThirdStepController@create')->name('thirdstep.create');
    Route::post('step-3', 'User\Wizard\ThirdStepController@store')->name('thirdstep.store');

	// STEP 4
	Route::get('step-4', 'User\Wizard\FourtStepController@create')->name('fourthstep.create');
	Route::post('step-4', 'User\Wizard\FourtStepController@store')->name('fourthstep.store');
});
