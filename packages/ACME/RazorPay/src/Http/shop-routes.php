
<?php

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {
 		// Get Route For Show Payment Form
		Route::get('paywithrazorpay', 'ACME\RazorPay\Http\Controllers\RazorpayController@payWithRazorpay')->name('paywithrazorpay');
		// Post Route For Makw Payment Request
		Route::post('payment', 'ACME\RazorPay\Http\Controllers\RazorpayController@payment')->name('payment');

		Route::get('paywithrazorpay', 'ACME\RazorPay\Http\Controllers\RazorpayController@payWithRazorpay')
		    ->name('paywithrazorpay')
		    ->defaults('_config', [
		        'view' => 'shop::static.payWithRazorpay'
		]);

		Route::post('payment', 'ACME\RazorPay\Http\Controllers\RazorpayController@payment')
		    ->name('payment');
});
