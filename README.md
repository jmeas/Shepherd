<strong></strong>#Shepherd

_version 0.5.0_

Shepherd is a simple PHP framework that was influenced by the [MVC](http://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) and [RMR](http://www.peej.co.uk/articles/rmr-architecture.html) architectures.

It was designed to allow you to quickly build [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer) webapps.

###Should I use Shepherd for my production website?

You definitely could, but I would suggest that you consider other alternatives first. You see, there are numerous more-developed PHP frameworks out there with great communities (from what I hear), which would probably be better for you. Shepherd is relatively new, so it has far fewer features than many of those listed frameworks, and further it has no community (that I know of).

In no particular order, here's a short list of popular PHP frameworks: [CakePHP](http://cakephp.org/), [CodeIgniter](http://ellislab.com/codeigniter), [Symfony](http://symfony.com/), [Zend](http://framework.zend.com/), and a lesser-known one that's worth a look: [Tonic](http://peej.github.io/tonic/).

###If not in production, then what should I use this for?

Shepherd is probably best suited to be a learning tool. If you're interested in learning how to write your own OOP PHP MVC (boy, that's a lot of acronyms), like I was, then I encourage you to peruse the source.

##Installation

To start, place the Shepherd source files in `Frameworks/Shepherd/`.

Then, put the `config.php` file into the root of your project along with the proper server configuration file. The source contains both a `.webconfig` file for IIS and an `.htaccess` file for Apache. If you're on another server, you'll need to set up a URL rewrite rule that takes all requests and points them to `Frameworks/Shepherd/autoload.php`.

_If you wish to change the directory of your Shepherd install, the only thing you'll need to change is the path in your server's rewrite rule._

###Configuration

The Config.php file contains a class that defines constants that can be used to configure your site. Here's a brief rundown of what they do:

- `PROJECT_NAME`: The (case-sensitive) name of the directory that Shepherd looks in to find your site's files.
- `DEBUG`: A boolean representing whether the site is in Debug mode or not. Displays some (not many) Shepherd-related errors when set to true.
- `MEDIA_DIRECTORY`: The directory Shepherd looks in to find user-uploaded content.
- `STATIC_DIRECTORY`: The location of the static files of your site, like `.css` and `.js` files.
- `DATA_DIRECTORY`: The directory for data files, like `.xml` or `.json`. This data is not directly accessible via any URL.
- `VIEWS_DIRECTORY`: Where Shepherd will look to find your app's view files.
- `TEMPLATES_DIRECTORY`: The base directory for your template files
- `LOGIN_URL`: If you set up authentication on your site, this is the path users will be redirected to when they are unauthorized.

####Coming Soon

- `MEDIA_URL`: If you wish to change the URL to access media. The default is `/media`.
- `STATIC_URL`: The URL to access those static files.

##Url Routing

Shepherd looks for a single file, `urls.php`, in the project directory. This file is where you manage your routing system. To write URLs, instantiate a new `Urls` object within this file, passing it an array whose values take the form:

    'regex to match' => 'view name'

To take a simple example, you might write:

    new Urls(
      array(
        '~[0-9]{4}/?$~'   =>   'numbers',  // This would pass a URL like /3444 to the view 'numbers'
        'login/?$'        =>   'login'
      )
    );

_Note: View names in the URL scheme (and across Shepherd, in general) are **case-insensitive**._

##Views

Shepherd looks inside the `{PROJECT_NAME}/views` folder to locate your views. Each view should go in a file that has the same name as the view, and that file should define a Class that yet again uses that same name. For instance, we may have (continuing the above example), a file `login.php` that contains:

    class Numbers extends View {
      // Functions and variables here
    }

Views have 4 core functions that correspond to the four HTTP methods: `GET`, `POST`, `PUT`, and `DELETE`. In this way, Shepherd promotes building RESTful webapps.

By default, Shepherd responds to any `GET` requests with a 200 OK response, while the other three are given a `403 FORBIDDEN`.

There's one other core helper function: `GET_Ajax`. If this function exists when your page is accessed via Ajax, it will be called instead of the regular `GET` function.

Of course, you're not limited to these four functions by any means. However, it is good practice to have other function calls stem from these five so that it is easy to follow the flow of a web request.

###The Four View Functions

What you do inside the core functions is up to you. Common things would be gathering data, loading an `html` template to display data, calling other functions, or sending back an HTTP response.

####HTTP Responses

It's really simple to set up server responses with the most common HTTP response headers. Simply instantiate a new `httpResponse` object in your view, passing it the name of the response you'd like to give. For instance, a 404 error can be given by:

    new httpResponse( 'Not Found' );

_Note: A header is set in the constructor of the httpResponse object. What this means is that no output can be sent (like an `echo`) before you instantiate the object._

####Resources

Shepherd comes with a simple system for handling resources stored in `json` files. But right now it's in need of some major work. It is intended to become an [ORM](http://en.wikipedia.org/wiki/Object-relational_mapping) system of sorts.

##Templating

Shepherd is configured to work with the [Twig](http://twig.sensiolabs.org/) templating system right out of the box.

Using templates is a breeze. Simply set the `$_template` variable within your view, and Shepherd will look for that Twig template file in the `{PROJECT_NAME}/templates` folder.

For instance, inside the `GET` function of the `Login` view above, we might do:

    function GET() {
      $this->_template = 'app/login.html';
    }

This would look for the file `{PROJECT_NAME}/templates/app/login.html` to render.

*Note: The rendering of a template is done in the destructor of a view.*

_Note: If you wish to use another templating system, all of the Twig code can be found in the `render.php` file. It should be pretty simple to swap Twig for any system you want._

##Utils

The utilities of Shepherd are classes that contain static methods you can call at any time to, well, do things.

###Authentication

The authentication util works with data stored in `.json` files. I can't say that I would suggest you to use `Json` for storing secure user data; I'm just using it temporarily as I build the Authentication class.

####Cookie Based Sessions

Though Shepherd uses `Json`, the rest of its authentication is fairly robust.

###Tools

The Tools util provides a number of static commonly-used PHP functions. A list of those is coming soon.
