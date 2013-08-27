#Shepherd

_version 0.6.0_

Shepherd is a small PHP framework that promotes the MVC pattern for building webapps.

##Installation

To start, place the Shepherd source files in `Frameworks/Shepherd/`.

Then, put the `config.php` file into the root of your project along with the proper server configuration file. The source contains both a `.webconfig` file for IIS and an `.htaccess` file for Apache. If you're on another server you'll need to set up a URL rewrite rule that takes all requests and points them to `Frameworks/Shepherd/autoload.php`.

_As of now there is no simple way to change the directory of where you install Shepherd._

###Configuration

The Config.php file contains a class that defines constants that can be used to configure your site. Here's a brief rundown of what they do:

- `PROJECT_NAME`: The (case-sensitive) name of the directory that Shepherd looks in to find your site's files.
- `BASE_URL` The (case-sensitive) name of the directory for the root of your site, if your site is not in the base domain. For instance, if your app is hosted at `www.e.com/myapp`, then the `BASE_URL` should be '_myapp_'.
- `DEBUG`: A boolean representing whether the site is in Debug mode or not. Displays some (not many) Shepherd errors when set to true.
- `MEDIA_DIRECTORY`: The directory Shepherd looks in to find user-uploaded content.
- `STATIC_DIRECTORY`: The location of the static files of your site, like `.css` and `.js` files.
- `VIEWS_DIRECTORY`: Where Shepherd will look to find your app's view files.
- `TEMPLATES_DIRECTORY`: The base directory for your template files

##File Serving

Shepherd is a file server. You should store your static app files, such as your `CSS` and `JavaScript` files, in the `STATIC_DIRECTORY` in your app's directory. These will be served from root. For instance, the file `static/css/main.css` will be accessed via the URL `css/main.css`.

User-uploaded files should be stored in your app's `MEDIA_DIRECTORY`. These will also be served from root. To take an example, `media/images/profile_pic.jpg` would be accessed via `images/profile_pic.jpg`.

##Url Routing

Shepherd looks for a single file, `urls.json`, in the project directory. This file is where you manage your routing system. This JSON file should be an array of objects, with each object containing two properties. The properties are as follows.

- `pattern`: The regex to match the URL against
- `view`: The view that is served when a match is found

To take a simple example, you might have the following `urls.json` file:

    [
      {
        "pattern": "~[0-9]{4}/?$~",
        "view"   : "blogs"
      },
      {
        "pattern": "~about/?$~",
        "view"   : "about"
      }
    ]

The first URL object would match URLs such as `/2344` and send it to the view `blogs`. The second URL object would match `/about` and send it to the `about` view.

_Note: View names in the URL scheme (and across Shepherd in general) are **case-insensitive**._

##Views

Shepherd looks inside the `{PROJECT_NAME}/views` folder to locate your views. Each view should go in a file that has the same name as the view, and that file should define a Class that yet again uses that same name. For instance, we may have (continuing the above example), a file `about.php` that contains:

    class About extends View {
      // Do your things
    }

Views have 4 core functions that correspond to the four HTTP methods: `GET`, `POST`, `PUT`, and `DELETE`. In this way, Shepherd promotes building RESTful webapps.

By default, Shepherd responds to any `GET` requests with a `200 OK` response, while the other three are given a `403 FORBIDDEN`.

There's one other core helper function: `GET_AJAX`. If this function exists when your page is accessed via AJAX, it will be called instead of the regular `GET` function.

Of course, you're not limited to these four functions by any means. However, it is good practice to have other function calls stem from these five so that it is easy to follow the flow of a web response.

_Note: Shepherd comes with a shim to support `DELETE` and `PUT` variables._

###The Four View Functions

What you do inside the core functions is up to you. Common things would be gathering data, loading an `html` template to display data, calling other functions, or sending back an HTTP response code.

####HTTP Response Codes

Shepherd makes it simple to set up server responses with the most common HTTP response codes. Simply instantiate a new `httpResponseCode` object in your view, passing it the name of the response you'd like to give. For instance, a 404 error can be given by:

    new httpResponseCode( 'Not Found' );

_Note: A header is set in the constructor of the httpResponseCode object. What this means is that no output can be sent (like an `echo`) before you instantiate the object._

##Templating

Shepherd is configured to work with the [Twig](http://twig.sensiolabs.org/) templating system right out of the box.

Using templates is a breeze. Simply set the `$_template` variable within your view, and Shepherd will look for that Twig template file in the `{PROJECT_NAME}/templates` folder.

For instance, inside the `GET` function of the `Login` view above, we might do:

    function GET() {
      $this->_template = 'app/login.html';
    }

This would look for the file `{PROJECT_NAME}/templates/app/login.html` to render.

*Note: The rendering of a template is done in the destructor of a view.*

_Note: If you wish to use another templating system, all of the Twig code can be found within `render.php`. It should be pretty straightforward to swap Twig for any framework you prefer._

