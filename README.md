# ResponsiveWebDesign
Technologies used: Android SDK, Eclipse, Java 1.6, HTML, XML, CSS, PHP, JavaScript, Bootstrap, Ajax, JSON, jQuery, AWS, Zillow and Facebook API

Created a webpage that allows users to search for real estate listings using the Zillow API (www.zillow.com) and the results are be displayed in a tabular format.

The user enters values for street address, city and state before clicking on the Search button. Once the user clicks on the Search button, a JavaScript program checks that the data is valid. If the user did not enter one of the data items, then a message is shown with appropriate text requesting the user to provide the missing information. 

Once the validation is successful, the JavaScript function .ajax() is executed to start an asynchronous transaction with a PHP file (script) running on AWS server, and passing the street name, city name and state name as parameters of the transaction. 
The PHP file converts XML data received from Zillow to JSON and return it to your browser and use Javascript to extract data from it and display the result.
