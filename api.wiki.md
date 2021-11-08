# iApps API Development

---

#### Develop API From Zero:

---

#### Step 1: Create a Module:

`php artisan module:make HR`

#### Step 2: Create a Feature in a Module:

`php artisan module:make-model Designation -m HR`
The above command will create a Designation Entity and migration in HR Module

`php artisan module:make-controller DesignationsController HR`
The above command will create a controller named DesignationsController in HR module

#### Step 3: Fix Routes:

1. First Delete the Cache Routes:
   `php artisan route:cache`

1. Controll Versioning in `Modules/HR/Providers/RouteServiceProvider.php`, Check `mapApiRoutes()` function and add route prefix here:

    ```
    protected function mapApiRoutes()
       {
          Route::prefix('api/v1')
             ->middleware('api')
             ->namespace($this->moduleNamespace)
             ->group(module_path('HR', '/Routes/api.php'));
       }
    ```

1. In `Modules/HR/Routes` folder, delete the default URL from `web.php` and paste that in `api.php` like the above

    ```
       Route::prefix('hr')->group(function () {
          Route::apiResource('designations', 'DesignationsController'); // API Routes for Designations
       });
    ```

1. In `Modules/HR/Http/Controllers/DesignationsController.php` add an `index()` and add controller function here:

    ```
    /**
      * @OA\GET(
      *     path="/api/v1/hr/designations",
      *     tags={"Designations"},
      *     summary="Designation List",
      *     description="Designation List",
      *     operationId="index",
      *      @OA\Response(
      *          response=200,
      *          description="Designations List"
      *       ),
      *      @OA\Response(response=400, description="Bad request"),
      *      @OA\Response(response=404, description="Resource Not Found"),
      * )
      */
     public function index()
     {
         $arrayList = [
             array('name' => 'Akash', 'age' => 25),
             array('name' => 'Polash', 'age' => 24),
         ];

         return $arrayList;
     }
    ```

Serve PHP server `php artisan serve`

Now hit
http://localhost:8000/api/documentation

and you'll see a new Designation's API has come.

<img src="https://i.ibb.co/5xxXk9c/designations-api-demo.png" alt="designations-api-demo" />

So, this is how a basic api end point is being created.

#### Laravel Modules Commands:

1.  Create a new module.
    `php artisan module:make TestModule`

1.  Show list of all modules.
    `php artisan module:list`

1.  Delete a module from the application:
    `php artisan module:delete TestModule`

1.  Disable the specified module:
    `php artisan module:disable TestModule`

1.  Dump-autoload the specified module or for all module.
    `php artisan module:dump TestModule`

1.  Enable the specified module.
    `php artisan module:enable TestModule`

1.  Install the specified module by given package name (vendor/name).
    `php artisan module:install https://test.com/github/modules/TestModule`

1.  module:make-command Generate new Artisan command for the specified module.
1.  Generate new restful controller for the specified module.
    `php artisan module:make-controller TestController TestModule`
1.  module:make-event Create a new event class for the specified module
1.  module:make-factory Create a new model factory for the specified module.
1.  module:make-job Create a new job class for the specified
1.  module
1.  module:make-listener Create a new event listener class for the specified module
1.  module:make-mail Create a new email class for the specified module
1.  module:make-middleware Create a new middleware class for the specified module.
1.  Create a new migration for the specified module.
    `php artisan module:make-migration TestDepartment TestModule`

1.  module:make-model Create a new model for the specified module.
    `php artisan module:make-model VehicleType -m Logistic`
    1. Here `VehicleType` is the model name,
    1. `-m` for auto create migration,
    1. `Logistic` is the Module Name
    1. It will create an Entity and a Migration
1.  module:make-notification Create a new notification class for the specified module.
1.  module:make-policy Create a new policy class for the specified module.
1.  module:make-provider Create a new service provider class for the specified module.
1.  module:make-request Create a new form request class for the specified module.
1.  module:make-resource Create a new resource class for the specified module.
1.  module:make-rule Create a new validation rule for the specified module.
1.  module:make-seed Generate new seeder for the specified module.
1.  module:make-test Create a new test class for the specified module.
1.  module:migrate Migrate the migrations from the specified module or from all modules.
    `php artisan module:migrate TestModule`
    or,
    `php artisan module:migrate Logistic`
    1. Where, Logistic is the Module Name
    1. It will migrate all database from Logistic Module to that Database

1)  module:migrate-refresh Rollback & re-migrate the modules migrations.
1)  module:migrate-reset Reset the modules migrations.
1)  module:migrate-rollback Rollback the modules migrations.
1)  module:migrate-status Status for all module migrations
1)  module:publish Publish a module's assets to the application
1)  module:publish-config Publish a module's config files to the application
1)  module:publish-migration Publish a module's migrations to the application
1)  module:publish-translation Publish a module's translations to the application
1)  module:route-provider Create a new route service provider for the specified module.
1)  module:seed Run database seeder from the specified module or from all modules.
1)  module:setup Setting up modules folders for first use. module:unuse Forget the used module with module:use
1)  module:update Update dependencies for the specified module or for all modules.
1)  module:use Use the specified module.
1)  module:v6:migrate Migrate laravel-modules v5 modules statuses to v6.
1)  New Test
