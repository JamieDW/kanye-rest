# kanye-rest
 A laravel wrapper for the Kayne REST API

## Installation

I will presume you have a development environment already set up for PHP/Laravel.

1. Run the following command through your terminal to clone the repository: `git clone https://github.com/JamieDW/kanye-rest` then `cd kayne-rest`
2. You will then want to install the composer packages: `composer install`
3. Depending on your development environment, now is the time to serve the application locally.
4. We are now ready to test the Laravel application!

### Testing

I have used PHPUnit as my test framework as that already comes with a fresh Laravel installation; however, the tests will also work with the Pest testing framework if you prefer that.

1. To run the tests run the following in your terminal from the root folder of the application: `php artisan test`
2. The tests will automatically create an authentication token for any authenticated API routes.
3. If you would like to interact with the API yourself, you will need a REST client like Postman or Insomnia. The following API routes are available:
   - `{localhost}/api/quotes` - retrieves cached quotes.
   - `{localhost}/api/new` - retrieves new quotes.
   - `{localhost}/api/purge` - purges the cached quotes
4. However, all these routes are authenticated, so you will first need to generate an authentication token using the following artisan command. `php artisan app:create-token`
5. I have used bearer authentication method for this task. Simply copy the token and add it the request header of your REST client; it should look something like this. `Authorization: Bearer {token}`. Please note that the token expires after 10 minutes.
6. You are now set up to use the above API endpoints!

### Notes

Just some notes, improvements, and additions I would make if time was not an issue.

1. Because this project implements the 'Laravel Manager Design' pattern and only one quote driver was requested, I thought it would be useful to provide a second quote driver to show the power of this pattern using the following API: https://api.quotable.io/random
   - You can easily switch between the two by changing the following config `config/quote.php` `default` value.
2. For simplicity, I have chosen to cache the generated authentication tokens. This works nicely for this demonstration. However, I would lean towards storing tokens within a database normally. Note that the tokens expire after 10 minutes.
3. Quotes from the following API endpoint, `{localhost}/api/quotes` are cached. The first call to the default quote driver will fetch the unique quotes. Subsequent calls will return the cached quotes instead.
   - You can test this out by quickly hitting the endpoint over and over again; you will notice the response time will be very quick!
4. A new middleware was created called 'app/Http/Middleware/BearerTokenAuthentication.php' to handle authentication.

Finally, some improvements or additions I would make.

1. Displaying the quotes wasn't mentioned. But we could have created an endpoint within the web route to display the quotes fetched from the API.
   - We could include the options to retrieve a specific amount of quotes instead of 5, the ability to select the quote driver 'kayne-rest' or 'quotable' and a button to refresh the quotes.
2. User accounts: because authentication was mentioned, we could have leveraged Laravel's inbuilt authentication, which provides us with a 'User' model and means of logging in and registering. This could have then been extended to provide access tokens to these users.
3. Storing quotes. Rather than fetching the quotes from the quote provider, we could instead store these quotes within a 'quotes' table and fetch them within a background process. This removes the call to the external quote provider, resulting in quicker response times.







