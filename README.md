# Prest

Prest is a lightweight framework for PHP to build simple REST-APIs. It allows developers to define routes with dynamic elements.

## Setting things up

To use Prest you need an Apache-Webserver. Simply place the files in this repo in the directory where you want your api to be located. For example: If you place the files inside the `api`-folder, your REST-API will be available under `yourdomain.com/api/...`.

## Defining custom routes

When you want to define a custom route for example to access your users, you have to create a subdirectory inside the `modules`-folder. The name of this subdirectory will be used as the base of the api-path. In the case of "users" it will be `yourdomain.com/api/users/...`.
You can create as many directories as you like and name them whatever you want.

Inside of those directories you place a PHP-file for every HTTP-method you want to allow for this path like `get.php`, `post.php` or `put.php`. The `manager.php` file will automatically look for the matching method-file in the right directory and call it. For example: If someone accesses `yourdomain.com/api/users` with a HTTP-GET-request the manager will automatically consult the `get.php` file inside the `modules/users`-directory.

### Static routes

But now for the routes: Inside of the `get.php`-file you need to create a `$routes`-array:
```php
$routes = array();
```
This array will contain all allowed routes and the function that should be called whenever the route is accessed. You can define a static route like this:
```php
$routes["all"] = function () use ($PARAMS) {
  // your code
}
```
If this line is inside the `get.php` inside the `modules/users`-directory, you can access it like this: `yourdomain.com/api/users/all`.
The `$PARAMS`-array is basically an alias for the `$_GET`-array.

### Dynamic routes

If you want to pass additional parameters through the URL you can use dynamic routes. Every dynamic element starts with a `:`. The name and it's value will be contained in the `$VALUES`-array. An example:
```php
$routes[":name"] = function ($VALUES) use ($PARAMS) {
  // your code with $VALUE["name"]
}
```
This route can be acces via `yourdomain.com/api/users/foo`. Inside the function `$VALUE["name"]` will have the value `foo`.
