# Application flow

                                            +------------+
    +-----------+        +---------+        |            | +----> +-----------+
    |           | +----> | Routing | +----> |            |        | Libraries |
    |           |        +---------+        |            | <----+ +-----------+
    | index.php |                           | Controller |
    |           |        +---------+        |            | +----> +-----------+
    |           | <----+ |  View   | <----+ |            |        |  Models   |
    +-----------+        +---------+        |            | <----+ +-----------+
                                            +------------+

1. The `public/index.php` is the single point of contact between the user
and the system. This file initialize all the base resources needed to run 
Beerawecka.
2. The router examines the user request to determine the corresponding action.
This action is defined in a controller method.
3. The controller's action loads the model, the libraries and 
any other resources needed to process the specific request
4. The output is rendered and sent to the user.
