Version: 1.48

These examples are based on Lemon Way API documentation v6.9

 * `LemonWayKit.php`: calls to Lemon Way's DIRECKITXML and WEBKIT
 * `Examples.php`: shows how to combine API functionalities in order to do what you want
 * `index.php`: launches the examples, and used as a return page after 3D Secure card payment example


# GET STARTED

 * `LemonWayKit.php`: 
  - `$printInputAndOutputXml`: set if you want to print everything that you send to Lemon Way's webservices and Lemon Way's outputs.
  - `$accessConfig`: replace the URLs with the ones Lemon Way gave you. The password is the default one. 

 * `Examples.php`:
  - `$myUrls`: change to your URLs if you need to test Money-in by card in 3D Secure, using Atos/BNP secure form
	
 * index.php : 
  - uncomment whatever you want to test