# Controllers

The controllers are class wich provide a number of methods that are called
actions. Actions are methods on a controller that handle requests.
By default all public methods on a controller map to actions and are accessible
by a URL.

Actions are responsible for interpreting the request and creating the response.
Usually responses are in the form of a rendered view (HTML page, JSON object,
XML document, etc.).


## Design pattern

Controllers must be located inside the `app/controllers/` folder
or inside its subfolders. Controllers must be encasulated inside the 
`App\Controllers` namespace. If the file is in a sub folder that folder name
should be part of the namespace too.

A controller can optionnaly extend `\App\Core\Controller` to have an easy access
to the application services.

The default action of a controller is the `index` method.

    class Welcome extends \App\Core\Controller
    {

        public function __construct()
        {
            parent::__construct();
            $this->output->content_type('text', 'UTF-8');
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

By default the router give access to public methods from a request.
If you want hide a public method from a request, simply declare it by
prefixing method name with an underscore.

    public function _hidden() {}
    Trying to access it via the url like this will not work :
    exemple.com/index.php/welcome/_hidden/