#This method is not recommended
>There are at least 3 ways to consume the LemonWay API in PHP
 1. **[SoapClient]**: the casual method in PHP to consume any Web Service. It is the simplest (**and recommended**) way.
 2. **[SoapClient SDK]**: same with the first method, but all the structure of requests / responses are generated overhead with [`wsdl2phpgenerator`](http://wsdl2phpgenerator.github.io/wsdl2phpgenerator/)
 3. **[LemonWay SDK] (not recommended)**: call the web service as a normal http request [`curl_init`](http://php.net/manual/en/function.curl-init.php). The SDK will help you to parse the SOAP response.

This example demonstrates the third method.

Lemon Way PHP SDK
=================================================
Lemon Way SDK is a PHP client library to work with
[Lemon Way API](http://documentation.lemonway.fr/api-en).


Installation with Composer
-------------------------------------------------
You can use Lemon Way SDK library as a dependency in your project with [Composer](https://getcomposer.org/) (which is the preferred technique). Follow [these installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have Composer installed.
A composer.json file is available in the repository and it has been referenced from [Packagist](https://packagist.org/packages/lemonway/php-sdk).

The installation with Composer is easy and reliable:

Step 1 - Add the Lemon Way SDK as a dependency by executing the following command:

    you@yourhost:/path/to/your-project$ composer require lemonway/php-sdk:^1.0

Step 2 - Update your dependencies with Composer

    you@yourhost:/path/to/your-project$ composer update

Step 3 - Finally, be sure to include the autoloader in your project

    require_once '/path/to/your-project/vendor/autoload.php';

The Library has been added into your dependencies and is ready to be used.

Installation without Composer
-------------------------------------------------
SDK has been written in PHP 5.4. You should ensure that curl and openssl extensions (that are part of standard PHP distribution) are enabled in your PHP installation.

The project attempts to comply with PSR-4 specification for autoloading classes from file paths. As a namespace prefix is `LemonWay\` with base directory `/path/to/your-project/`.

But if you're not using PSR-4 or Composer, the installation is as easy as downloading the library and storing it under any location that will be available for including in your project (don't forget to include the required library dependencies though):
```php
    require_once '/path/to/your-project/LemonWay/Autoloader.php';
```

Contacts
-------------------------------------------------
Report bugs or suggest features using
[issue tracker on GitHub](https://github.com/lemonway/php-sdk).


Account creation
-------------------------------------------------
You need a sandbox to run Examples.


Configuration
-------------------------------------------------
Using the credentials information from Lemon Way support, you should then set `$api->config->wlLogin` to your Lemon Way login and `$api->config->wlPass` to your Lemon Way password.

```php
require_once '/path/to/your-project/vendor/autoload.php';
$api = new LemonWayAPI();

$api->config->dkUrl = 'Your DirectKitXML url';
$api->config->wkUrl = 'Your WebKit url';
$api->config->wlLogin = 'Your login';
$api->config->wlPass = 'Your password';
$api->config->lang = 'Your language';
//$api->config->isDebugEnabled = true; //Uncomment to turn on debug mode

// call some API methods...
$result = $api->RegisterWallet(...);
```

Response Object
-------------------------------------------------
All ```LemonWayAPI``` methods are returning ```\LemonWay\ApiResponse``` object.
It is a dynamic object with variable properties.

###**Fixed properties :**

|Property | Type | Description|
|---------|------|------------|
|lwError | [LemonWay\Models\LwError](LemonWay/Models/LwError.php) | LwError Object|
|lwXml | SimpleXMLElement | Raw xml return as SimpleXMLElement object. Details in [Lemon Way API](http://documentation.lemonway.fr/api-en)|


###**Variable properties:**

Those properties depends of which method was called.

|Property | Type | Description|
|---------|------|------------|
|wallets | array of [LemonWay\Models\Wallet](LemonWay/Models/Wallet.php) | Filled when the API returns multiple Wallets|
|operations | array of [LemonWay\Models\Operation](LemonWay/Models/Operation.php) | Filled when the API returns multiple Operations|
|wallet | [LemonWay\Models\Wallet](LemonWay/Models/Wallet.php) | Filled when the API returns only one Wallet|
|operation | [LemonWay\Models\Operation](LemonWay/Models/Operation.php) | Filled when the API returns only one Operation|
|kycDoc | [LemonWay\Models\KycDoc](LemonWay/Models/KycDoc.php) | Filled when the API returns a KycDoc|
|iban | [LemonWay\Models\Iban](LemonWay/Models/Iban.php) | Filled when the API returns an Iban|
|sddMandate | [LemonWay\Models\SddMandate](LemonWay/Models/SddMandate.php) | Filled when the API returns a SDD Mandate|

Sample usage
-------------------------------------------------
```php
require_once '/path/to/your-project/vendor/autoload.php';
$api = new LemonWayAPI();

$api->config->dkUrl = 'Your DirectKitXML url';
$api->config->wkUrl = 'Your WebKit url';
$api->config->wlLogin = 'Your login';
$api->config->wlPass = 'Your password';
$api->config->lang = 'Your language';


// call some API methods...
$walletID = 'Fill in with a unique id';
$response = $api->RegisterWallet(array('wallet' => $walletID,
                                        'clientMail' => $walletID.'@mail.fr',
                                        'clientTitle' => Wallet::UNKNOWN,
                                        'clientFirstName' => 'Paul',
                                        'clientLastName' => 'Atreides'));
if (isset($response->lwError)) {
    print 'Error, code '.$response->lwError->CODE.' : '.$response->lwError->MSG;
} else {
    print '<br/>Wallet created : ' . $response->wallet->ID;

    // OR BY USING lwXml :
    print '<br/>Wallet created : ' . $response->lwXml->WALLET->ID;
}
```

Get started with our examples
--------
In the [examples folder](examples), you can find **an example for each API method**.

_You need to run the examples in a web server with php configured and a **hostname different from localhost**._

_You also need a sandbox if you want to run examples (contact Lemon Way to create a sandbox)_

An **API method / example  match table** could be find in the [Index of examples folder](examples/index.php) in HTML format
and also in MarkDown in the [examples folder README.md](examples).

###**Configuration**
By default, the examples run with our sandbox demo.
If you need your own sandbox, please contact Lemon Way then do these configurations.
There's two files that handles the examples configuration:

| File | Description |
|------|-------------|
|[ExamplesDatas](examples/ExamplesDatas.php)| Random ID generator, Test card number, Test Iban ... |
|[ExamplesBootstrap](examples/ExamplesBootstrap.php)| API configuration (login, urls ...), API factory, Host configuration |


[`SoapClient`]: http://php.net/manual/en/class.soapclient.php
[SoapClient]: https://github.com/lemonwaysas/php-client-directkit-xml-soap
[SoapClient SDK]: https://github.com/lemonwaysas/php-client-directkit-xml-soap-sdk
[LemonWay SDK]: https://github.com/lemonwaysas/php-client-directkit-xml
[Lemonway Directkit API]: http://documentation.lemonway.fr/
