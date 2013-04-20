#Shepherd

Shepherd is a simple PHP framework that is heavily influenced by the [MVC](http://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) and [RMR](http://www.peej.co.uk/articles/rmr-architecture.html) architectures.

It was created to allow you to quickly build a RESTful website.

###Should I use Shepherd for my production website?

Probably not. This is my first attempt at an MVC, and it wasn't built to be used in a production environment. If you want to build a PHP site on a framework, there are a number of more extensive options around with great communities (from what I hear). Here's a short list, in no order: [CakePHP](http://cakephp.org/), [CodeIgniter](http://ellislab.com/codeigniter), [Symfony](http://symfony.com/), [Zend](http://framework.zend.com/), and one that's definitely worth a look: [Tonic](http://peej.github.io/tonic/) (an [RMR](http://www.peej.co.uk/articles/rmr-architecture.html) framework).

###Then what should I use this for?

Shepherd is probably best used as a tool for learning. On account of it being my first take at an MVC, I imagine that it may be a simpler to study than other frameworks. If you're interested in learning how to write your own MVC like I was then I suggest perusing the source.

##Installation

Place the Shepherd source files in `/Frameworks/Shepherd/`.

Then, put the `config.php` file into the root of your project along with the proper server configuration file. The source contains both a `.webconfig` file for IIS and an `.htaccess` file for Apache. If you're on another server, you'll need to write a URL rewrite that takes all requests and points them to `/Frameworks/Shepherd/autoload.php`.

_To change the directory of your Shepherd install, you'll only need to change the server config file._

###Configuration

The Config.php file is just a class with some constants that can be used to configure your site. Here's a brief rundown of what they do:

`PROJECT_NAME`: The name of the directory that Shepherd looks in to find your site's files.
`DEBUG`: A boolean representing whether the site is in Debug mode or not. Displays some (not many) Shepherd-related errors when set to true.

`MEDIA_DIRECTORY`: The URL Shepherd looks at for serving user-uploaded content.
`MEDIA_URL`: If you wish to change the URL to access media. The default is `/media`.

`STATIC_DIRECTORY`: The URL for serving your site's static contents, like `.css` and `.js` files.

`DATA_DIRECTORY`: The directory for data files, like `.xml` or `.json`. Not accessible via any URL.

`LOGIN_URL`: If you set up authentication on your site, this is the path users will be redirected to if they are unauthorized.

##Templating

There's no templating system built into Shepherd. I chose to use [Twig](http://twig.sensiolabs.org/) for the projects I've built on Shepherd, but due to the separation of concerns of the project it'd be pretty to switch that out for any framework you prefer.

##Url Routing

Shepherd looks for a single file, `urls.php`, in the project directory. To write URLs, instantiate a new `Urls` object, passing an array whose values take the form:

    `regex to match` -> `view name`

So, to take a simple example, you might write:

    new Urls(
      array(
        '~[0-9]{4}/?$~' => 'numbers',
        'login/?$' => 'login',
      )
    );

##Views

Shepherd looks inside the `{PROJECT_NAME}/views` folder to locate your views. Each view should go in a file that has the same name as the view, and that file should define a Class that yet again uses that same name. For instance, we may have (continuing the above example), a file `login.php`

    class Login extends View {
    }

Views work with 4 core functions that correspond to the four HTTP methods: `GET`, `POST`, `PUT`, and `DELETE`. In this way, Shepherd makes it pretty easy to build RESTful webapps.

By default, Shepherd responds to any `GET` requests with a 200 OK response, while the other three are responded to with `403 FORBIDDEN`.

There's one other helper function: `GET_Ajax`. If this function exists when your page is accessed via Ajax, it will be called instead of the regular `GET` function.

##Templating

What you do inside those functions is up to you. You can load a template to display, gather data to send over, or do whatever. Shepherd is configured to work with Twig right out of the box. If you set the `$_template` variable within a function, then Shepherd will look for that Twig template file in the `{PROJECT_NAME}/templates` folder.

For instance, inside that `Login` view above, we might do:

    $this->_template = 'login.html';

##Authentication

Shepherd comes out of the box with authentication. But the documentation on it will come later!