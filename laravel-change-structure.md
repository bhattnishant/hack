```php
        
//include dirctory.php and run below function

public function copyFromMVCtoModuleMVC()
{
        //Uncomment one by one and run
        
        /**
        $path = app_path('Http/Controllers');
        $subDir = 'Controllers';

        $path = app_path('Repositories');
        $subDir = 'Repositories';
             
        $path = app_path('Validators');
        $subDir = 'Validators';           
        **/

      
        /***          
          $path = resource_path('views/admin');
          $subDir = 'Views';
        **/              
        
        $modules = Directory::listDirectories($path);
        //dd($modules);

        foreach ($modules as $module) {
            $files = Directory::listFolderFiles($path.'/'.$module);
            foreach ($files as $key=>$file) {
            
                @mkdir(app_path('Modules'));    
                
                $origin_module = $module;
                $module = str_replace(' ','',ucwords(str_replace('_',' ',$module)));
                try
                {

                @mkdir(app_path('Modules/'.$module));
                @mkdir(app_path('Modules/'.$module.'/'.$subDir));
                @mkdir(app_path('Modules/'.$module.'/'.$subDir.'/'.$origin_module));

                if(is_array($file))
                {                    
                    foreach ($file as $key2=>$inside)
                    {
                        if(is_array($inside))
                        {
                            foreach ($inside as $inside2)
                            {
                                @mkdir(app_path('Modules/' . $module . '/' . $subDir .'/'.$origin_module. '/' . $key));
                                @mkdir(app_path('Modules/' . $module . '/' . $subDir .'/'.$origin_module. '/' . $key.'/'.$key2));
                                $newPath = app_path('Modules/' . $module . '/' . $subDir .'/'.$origin_module. '/' . $key . '/' . $key2.'/'.$inside2);                                
                                echo @copy($path . '/' . $origin_module . '/' . $key. '/' . $key2. '/' . $file, $newPath);
                            }
                        } else {
                            @mkdir(app_path('Modules/' . $module . '/' . $subDir .'/'.$origin_module. '/' . $key));
                            $newPath = app_path('Modules/' . $module . '/' . $subDir .'/'.$origin_module. '/' . $key . '/' . $inside);                            
                            echo @copy($path . '/' . $origin_module . '/' . $key. '/' . $file, $newPath);
                        }
                    }

                } else {
                    $newPath = app_path('Modules/'.$module.'/'.$subDir.'/'.$origin_module.'/'.$file);
                    echo @copy($path.'/'.$origin_module.'/'.$file, $newPath);
                }

                } catch (\Exception $e) {                    
                    dd($e, $module, $file, $files);
                }
            }                     
        }
    }
  ?> 
  ```
    
    
    *Below code will list NameSpace command which can run from terminal*
  ```php
    $modules = Directory::listDirectories(app_path('Modules'));
    
    foreach ($modules as $module) {

        $s = "App\\\\Http\\\\Controllers\\\\".$module;                
        $e = "App\\\\Modules\\\\".$module."\\\\Controllers";

        $s = "App\\\\Models\\\\".$module;                
        $e = "App\\\\Modules\\\\".$module."\\\\Models";

        $s = "App\\\\Repositories\\\\".$module;                
        $e = "App\\\\Modules\\\\".$module."\\\\Repositories";

        $s = "App\\\\Validators\\\\".$module;                
        $e = "App\\\\Modules\\\\".$module."\\\\Validators";

        echo 'find app/Modules/ -type f -exec \\<br>
                sed -i \'s/'.$s.'/'.$e.'/g\' {} +';
    }
 ```  
    
    *Put below lines inside RouteServiceProvider Boot*
```php
    $modules = Directory::listDirectories(app_path('Modules'));
    foreach ($modules as $module) {
      $routesPath = app_path('Modules/' . $module . '/routes.php');
      $viewsPath = app_path('Modules/' . $module . '/Views');

      if (file_exists($routesPath)) {
          include_once($routesPath);
      }

      if (file_exists($viewsPath)) {
          $this->app->view->addLocation($viewsPath);
      }
    }
```
    
    
    
    
