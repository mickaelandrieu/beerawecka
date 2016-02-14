# Controllers

The controllers are classes which provide a number of methods that are called
actions. Actions are methods on a controller that handle requests.
By default all public conrollers's methods map to actions that are accessible
by an URL
*(See [URI Routing chapter](https://github.com/sugatasei/beerawecka/blob/master/doc/03-uri-routing.md))*.

Actions are responsible for interpreting the request and creating the response.
Usually responses come in the form of a rendered view (HTML page, JSON object,
XML document, etc.).

## Design pattern

Controllers must be located inside the `app/controllers/` folder
or inside its subfolders. Controllers must be encapsulated inside the 
`App\Controllers` namespace. If the file is in a sub folder that folder name
should be part of the namespace too.

A controller can optionnaly extend `\App\Core\Controller` to have an easy access
to the application services.

The default action of a controller is the `index` method.

Example:

    class Welcome extends \App\Core\Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->output->contentType('text', 'UTF-8');
        }

        public function index()
        {
            $this->output->add(__METHOD__ . PHP_EOL);
        }

        public function hello_world()
        {
            $this->output->add(__METHOD__ . PHP_EOL);
        }
    }

## Hidden methods

By default the router gives access to public methods from a request.
If you want to hide a public method from a request, simply declare it by
prefixing the method name with an underscore.

    public function _hidden() {}

Trying to access it via the url like this will not work:

    example.com/index.php/welcome/_hidden/