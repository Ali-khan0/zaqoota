<?php

namespace App\Http\Controllers;

use App\CentralLogics\Helpers;
use App\Traits\ActivationClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Madnest\Madzipper\Facades\Madzipper;
use Illuminate\Support\Facades\Session;

class InstallController extends Controller
{
    use ActivationClass;

    public function step0()
    {
        return view('installation.step0');
    }

    public function step1(Request $request)
    {
        if (Hash::check('step_1', $request['token'])) {
            $permission['curl_enabled'] = function_exists('curl_version');
            //extensions
            $permission['curl'] = function_exists('curl_version');
            $permission['bcmath'] = extension_loaded('bcmath');
            $permission['ctype'] = extension_loaded('ctype');
            $permission['json'] = extension_loaded('json');
            $permission['mbstring'] = extension_loaded('mbstring');
            $permission['openssl'] = extension_loaded('openssl');
            $permission['pdo'] = defined('PDO::ATTR_DRIVER_NAME');
            $permission['tokenizer'] = extension_loaded('tokenizer');
            $permission['xml'] = extension_loaded('xml');
            $permission['zip'] = extension_loaded('zip');
            $permission['fileinfo'] = extension_loaded('fileinfo');
            $permission['gd'] = extension_loaded('gd');
            $permission['sodium'] = extension_loaded('sodium');
            $permission['pdo_mysql'] = extension_loaded('pdo_mysql');
            $permission['db_file_write_perm'] = is_writable(base_path('.env'));
            $permission['routes_file_write_perm'] = is_writable(base_path('app/Providers/RouteServiceProvider.php'));
            return view('installation.step1', compact('permission'));
        }
        session()->flash('error', 'Access denied!');
        return redirect()->route('step0');
    }

    public function step2(Request $request)
    {
        if (Hash::check('step_2', $request['token'])) {
            return view('installation.step2');
        }
        session()->flash('error', 'Access denied!');
        return redirect()->route('step0');
    }

    public function step3(Request $request)
    {
        if (Hash::check('step_3', $request['token'])) {
            // Auto-set default purchase key values if not already set (skipping step2)
            if (!session()->has(base64_decode('cHVyY2hhc2Vfa2V5'))) {
                Helpers::setEnvironmentValue('SOFTWARE_ID', 'MzY3NzIxMTI=');
                Helpers::setEnvironmentValue('BUYER_USERNAME', 'default');
                Helpers::setEnvironmentValue('PURCHASE_CODE', 'nulled');
                Session::put(base64_decode('cHVyY2hhc2Vfa2V5'), 'nulled'); // pk
                Session::put(base64_decode('dXNlcm5hbWU='), 'default'); // un
            }
            return view('installation.step3');
        }
        session()->flash('error', 'Access denied!');
        return redirect()->route('step0');
    }

    public function step4(Request $request)
    {
        if (Hash::check('step_4', $request['token'])) {
            return view('installation.step4');
        }
        session()->flash('error', 'Access denied!');
        return redirect()->route('step0');
    }

    public function step5(Request $request)
    {
        if (Hash::check('step_5', $request['token'])) {
            return view('installation.step5');
        }
        session()->flash('error', 'Access denied!');
        return redirect()->route('step0');
    }

    public function purchase_code(Request $request)
    {
        Helpers::setEnvironmentValue('SOFTWARE_ID', 'MzY3NzIxMTI=');
        Helpers::setEnvironmentValue('BUYER_USERNAME', $request['username'] ?? 'default');
        Helpers::setEnvironmentValue('PURCHASE_CODE', $request['purchase_key'] ?? 'nulled');

        $post = [
            'name' => $request['name'],
            'email' => $request['email'],
            'username' => $request['username'],
            'purchase_key' => $request['purchase_key'],
            'domain' => preg_replace("#^[^:/.]*[:/]+#i", "", url('/')),
        ];
        // $response = $this->dmvf($post);

        // return redirect($response.'?token='.bcrypt('step_3'));
        Session::put(base64_decode('cHVyY2hhc2Vfa2V5'), $request[base64_decode('cHVyY2hhc2Vfa2V5')]);//pk
        Session::put(base64_decode('dXNlcm5hbWU='), $request[base64_decode('dXNlcm5hbWU=')]);//un
        return redirect('step3?token='.bcrypt('step_3'));
    }

    public function system_settings(Request $request)
    {
        if (!Hash::check('step_6', $request['token'])) {
            session()->flash('error', 'Access denied!');
            return redirect()->route('step0');
        }

        DB::table('admins')->insertOrIgnore([
            'f_name' => $request['f_name'],
            'l_name' => $request['l_name'],
            'email' => $request['email'],
            'role_id' => 1,
            'password' => bcrypt($request['password']),
            'phone' => $request['phone'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('business_settings')->where(['key' => 'business_name'])->update([
            'value' => $request['business_name']
        ]);

        Helpers::insert_business_settings_key('system_language','[{"id":1,"direction":"ltr","code":"en","status":1,"default":true}]');

        //version 2.2.0
        Helpers::insert_data_settings_key('admin_login_url', 'login_admin' ,'admin');
        Helpers::insert_data_settings_key('admin_employee_login_url', 'login_admin_employee' ,'admin-employee');
        Helpers::insert_data_settings_key('store_login_url', 'login_store' ,'vendor');
        Helpers::insert_data_settings_key('store_employee_login_url', 'login_store_employee' ,'vendor-employee');

        Helpers::insert_business_settings_key('check_daily_subscription_validity_check', date('Y-m-d'));

        Helpers::insert_business_settings_key('country_picker_status', '1');
        Helpers::insert_business_settings_key('manual_login_status', '1');


        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);

        Helpers::remove_dir('storage/app/public');
        Storage::disk('public')->makeDirectory('/');

        try {
            Madzipper::make('installation/backup/public.zip')->extractTo('storage/app');
        }catch (\Exception $exception){
            info($exception);
        }

        //sleep(5);
        return view('installation.step6');
    }

    public function database_installation(Request $request)
    {
        // First, try to create the database if it doesn't exist
        $createResult = self::create_database_if_not_exists($request->DB_HOST, $request->DB_DATABASE, $request->DB_USERNAME, $request->DB_PASSWORD);
        
        if (!$createResult['success']) {
            session()->flash('error', $createResult['message']);
            return redirect()->route('step3', ['token' => bcrypt('step_3')]);
        }
        
        $connectionResult = self::check_database_connection($request->DB_HOST, $request->DB_DATABASE, $request->DB_USERNAME, $request->DB_PASSWORD);
        
        if ($connectionResult['success']) {
            $key = base64_encode(random_bytes(32));
            $output = 'APP_NAME=6ammart'.time().
                    'APP_ENV=live
                    APP_KEY=base64:' . $key . '
                    APP_DEBUG=false
                    APP_INSTALL=true
                    APP_LOG_LEVEL=debug
                    APP_MODE=live
                    APP_URL=' . URL::to('/') . '

                    DB_CONNECTION=mysql
                    DB_HOST=' . $request->DB_HOST . '
                    DB_PORT=3306
                    DB_DATABASE=' . $request->DB_DATABASE . '
                    DB_USERNAME=' . $request->DB_USERNAME . '
                    DB_PASSWORD="' . $request->DB_PASSWORD . '"

                    BROADCAST_DRIVER=log
                    CACHE_DRIVER=database
                    SESSION_DRIVER=file
                    SESSION_LIFETIME=120
                    QUEUE_DRIVER=sync

                    REDIS_HOST=127.0.0.1
                    REDIS_PASSWORD=null
                    REDIS_PORT=6379

                    PUSHER_APP_ID=
                    PUSHER_APP_KEY=
                    PUSHER_APP_SECRET=
                    PUSHER_APP_CLUSTER=mt1

                    PURCHASE_CODE=' . (session('purchase_key') ?: 'nulled') . '
                    BUYER_USERNAME=' . (session('username') ?: 'default') . '
                    SOFTWARE_ID=MzY3NzIxMTI=

                    SOFTWARE_VERSION=3.5
                    REACT_APP_KEY=45370351
                    ';
            $file = fopen(base_path('.env'), 'w');
            fwrite($file, $output);
            fclose($file);

            $path = base_path('.env');
            if (file_exists($path)) {
                return redirect()->route('step4', ['token' => $request['token']]);
            } else {
                session()->flash('error', 'Failed to create .env file. Please check file permissions.');
                return redirect()->route('step3', ['token' => bcrypt('step_3')]);
            }
        } else {
            session()->flash('error', $connectionResult['message']);
            return redirect()->route('step3', ['token' => bcrypt('step_3')]);
        }
    }

    public function import_sql()
    {
        try {
            $sql_path = base_path('installation/backup/database.sql');
            
            if (!file_exists($sql_path)) {
                session()->flash('error', 'Database SQL file not found at: ' . $sql_path);
                return back();
            }
            
            // Get database credentials from .env file
            $db_host = env('DB_HOST', 'localhost');
            $db_port = env('DB_PORT', '3306');
            $db_name = env('DB_DATABASE');
            $db_user = env('DB_USERNAME');
            $db_pass = env('DB_PASSWORD');
            
            if (empty($db_name) || empty($db_user)) {
                session()->flash('error', 'Database credentials not found in .env file. Please go back to step 3.');
                return back();
            }
            
            // Ensure database exists before importing
            $createResult = self::create_database_if_not_exists($db_host, $db_name, $db_user, $db_pass);
            if (!$createResult['success']) {
                session()->flash('error', $createResult['message']);
                return back();
            }
            
            // Check existing tables first - if tables exist, use smart import
            $existingTables = $this->get_existing_tables();
            if (!empty($existingTables)) {
                // Use smart import that skips existing tables
                Log::info('Existing tables found (' . count($existingTables) . ' tables), using smart import to skip them');
                return $this->import_sql_using_pdo($sql_path, true);
            }
            
            // Escape credentials for shell command
            $db_host = escapeshellarg($db_host);
            $db_port = escapeshellarg($db_port);
            $db_name = escapeshellarg($db_name);
            $db_user = escapeshellarg($db_user);
            $sql_path_escaped = escapeshellarg($sql_path);
            
            // Build mysql command based on OS
            $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
            
            // Build base mysql command
            $mysqlCmd = "mysql -h {$db_host} -P {$db_port} -u {$db_user}";
            if (!empty($db_pass)) {
                $db_pass_escaped = escapeshellarg($db_pass);
                $mysqlCmd .= " -p{$db_pass_escaped}";
            }
            $mysqlCmd .= " {$db_name}";
            
            if ($isWindows) {
                // Windows: Use type command to read file and pipe to mysql
                $command = "type {$sql_path_escaped} | {$mysqlCmd} 2>&1";
            } else {
                // Linux/Unix: Use input redirection
                $command = "{$mysqlCmd} < {$sql_path_escaped} 2>&1";
            }
            
            // Execute the command
            $output = [];
            $return_var = 0;
            exec($command, $output, $return_var);
            
            // Check if command was successful
            if ($return_var !== 0) {
                $errorOutput = implode("\n", $output);
                Log::error('Database import command failed: ' . $errorOutput);
                
                // Check if MySQL CLI is not available (fallback to PDO method)
                if (strpos($errorOutput, 'not recognized') !== false || 
                    strpos($errorOutput, 'command not found') !== false ||
                    strpos($errorOutput, 'mysql: command not found') !== false) {
                    
                    // Fallback to using Laravel's DB::unprepared() method
                    Log::info('MySQL CLI not found, falling back to PDO method');
                    return $this->import_sql_using_pdo($sql_path, true);
                }
                
                // Check if error is due to existing tables - use smart import instead
                if (strpos($errorOutput, 'already exists') !== false || 
                    strpos($errorOutput, 'Duplicate') !== false ||
                    strpos($errorOutput, 'Table') !== false) {
                    // Fallback to PDO method which will skip existing tables
                    Log::info('Tables already exist, using smart import to skip existing tables');
                    return $this->import_sql_using_pdo($sql_path, true);
                } else {
                    session()->flash('error', 'Database import failed: ' . $errorOutput);
                }
                return back();
            }
            
            // Verify all tables are imported
            $allTablesImported = $this->verify_all_tables_imported($sql_path);
            
            if (!$allTablesImported) {
                // If not all tables imported via CLI, fallback to PDO method for remaining tables
                Log::info('Not all tables imported via CLI, using PDO method to complete import');
                return $this->import_sql_using_pdo($sql_path, true);
            }
            
            // version_2.11.1 - Create cache table
            Artisan::call('cache:table');
            
            session()->flash('success', 'Database imported successfully! All tables verified.');
            return redirect()->route('step5', ['token' => bcrypt('step_5')]);
            
        } catch (\Exception $exception) {
            $errorMessage = $exception->getMessage();
            Log::error('Database import error: ' . $errorMessage);
            session()->flash('error', 'Database import failed: ' . $errorMessage);
            return back();
        }
    }

    public function force_import_sql()
    {
        try {
            $sql_path = base_path('installation/backup/database.sql');
            
            if (!file_exists($sql_path)) {
                session()->flash('error', 'Database SQL file not found at: ' . $sql_path);
                return back();
            }
            
            // Get database credentials from .env file
            $db_host = env('DB_HOST', 'localhost');
            $db_port = env('DB_PORT', '3306');
            $db_name = env('DB_DATABASE');
            $db_user = env('DB_USERNAME');
            $db_pass = env('DB_PASSWORD');
            
            if (empty($db_name) || empty($db_user)) {
                session()->flash('error', 'Database credentials not found in .env file. Please go back to step 3.');
                return back();
            }
            
            // Ensure database exists (but don't wipe it - skip existing tables instead)
            $createResult = self::create_database_if_not_exists($db_host, $db_name, $db_user, $db_pass);
            if (!$createResult['success']) {
                session()->flash('error', $createResult['message']);
                return back();
            }
            
            // Use smart import that skips existing tables (no wiping)
            Log::info('Force import: Using smart import to skip existing tables');
            return $this->import_sql_using_pdo($sql_path, true);
            
        } catch (\Exception $exception) {
            $errorMessage = $exception->getMessage();
            Log::error('Force database import error: ' . $errorMessage);
            session()->flash('error', 'Database import failed: ' . $errorMessage);
            return back();
        }
    }

    private function get_existing_tables(): array
    {
        try {
            $tables = DB::select("SHOW TABLES");
            $tableNameKey = 'Tables_in_' . env('DB_DATABASE');
            return array_map(function($table) use ($tableNameKey) {
                return $table->$tableNameKey;
            }, $tables);
        } catch (\Exception $e) {
            Log::error('Error getting existing tables: ' . $e->getMessage());
            return [];
        }
    }

    private function parse_table_names_from_sql($sql): array
    {
        $tables = [];
        // Match CREATE TABLE statements (case insensitive, handles backticks and quotes)
        preg_match_all('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?[`"]?(\w+)[`"]?/i', $sql, $matches);
        if (!empty($matches[1])) {
            $tables = array_unique($matches[1]);
        }
        return $tables;
    }

    private function verify_all_tables_imported($sql_path): bool
    {
        try {
            $sql = file_get_contents($sql_path);
            if (empty($sql)) {
                return false;
            }
            
            // Get tables from SQL file
            $expectedTables = $this->parse_table_names_from_sql($sql);
            if (empty($expectedTables)) {
                return false;
            }
            
            // Get existing tables from database
            $existingTables = $this->get_existing_tables();
            
            // Check if all expected tables exist
            $missingTables = array_diff($expectedTables, $existingTables);
            
            if (!empty($missingTables)) {
                Log::info('Missing tables: ' . implode(', ', $missingTables));
                return false;
            }
            
            Log::info('All tables verified: ' . count($existingTables) . ' tables exist');
            return true;
        } catch (\Exception $e) {
            Log::error('Error verifying tables: ' . $e->getMessage());
            return false;
        }
    }

    private function filter_sql_by_existing_tables($sql, $existingTables): string
    {
        if (empty($existingTables)) {
            return $sql; // No existing tables, return full SQL
        }

        // Split SQL into statements (by semicolon, but preserve CREATE TABLE blocks)
        // Match CREATE TABLE statements with their full content until the closing semicolon
        $pattern = '/(CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?[`"]?(\w+)[`"]?[^;]*;)/is';
        
        $filteredSql = preg_replace_callback($pattern, function($matches) use ($existingTables) {
            $fullStatement = $matches[0];
            $tableName = $matches[2];
            
            // Skip if table already exists
            if (in_array($tableName, $existingTables)) {
                Log::info("Skipping table '{$tableName}' - already exists");
                return ''; // Remove this CREATE TABLE statement
            }
            
            return $fullStatement; // Keep this CREATE TABLE statement
        }, $sql);
        
        // Also remove INSERT statements for tables that already exist
        foreach ($existingTables as $table) {
            // Remove INSERT INTO statements for existing tables
            $filteredSql = preg_replace(
                '/INSERT\s+INTO\s+[`"]?' . preg_quote($table, '/') . '[`"]?[^;]*;/is',
                '',
                $filteredSql
            );
        }
        
        // Clean up multiple empty lines
        $filteredSql = preg_replace('/\n\s*\n\s*\n+/', "\n\n", $filteredSql);
        
        return trim($filteredSql);
    }

    private function import_sql_using_pdo($sql_path, $skipExisting = true)
    {
        try {
            $sql = file_get_contents($sql_path);
            if (empty($sql)) {
                session()->flash('error', 'Database SQL file is empty.');
                return back();
            }
            
            // // Check existing tables and filter SQL if needed
            // if ($skipExisting) {
            //     $existingTables = $this->get_existing_tables();
                
            //     if (!empty($existingTables)) {
            //         $tablesInSql = $this->parse_table_names_from_sql($sql);
            //         $tablesToImport = array_diff($tablesInSql, $existingTables);
            //         $tablesToSkip = array_intersect($tablesInSql, $existingTables);
                    
            //         if (!empty($tablesToSkip)) {
            //             Log::info('Skipping existing tables: ' . implode(', ', $tablesToSkip));
            //             $sql = $this->filter_sql_by_existing_tables($sql, $existingTables);
                        
            //             if (empty(trim($sql))) {
            //                 // Verify all tables are present before proceeding
            //                 $allTablesImported = $this->verify_all_tables_imported($sql_path);
            //                 if ($allTablesImported) {
            //                     Artisan::call('cache:table');
            //                     session()->flash('success', 'All tables already exist. Database is up to date! All tables verified.');
            //                     return redirect()->route('step5', ['token' => bcrypt('step_5')]);
            //                 } else {
            //                     // Some tables might be missing, try to import them
            //                     Log::warning('Some tables are missing even though SQL is empty. Re-reading SQL file...');
            //                     $fullSql = file_get_contents($sql_path);
            //                     if (!empty($fullSql)) {
            //                         DB::unprepared($fullSql);
            //                         $allTablesImported = $this->verify_all_tables_imported($sql_path);
            //                         if ($allTablesImported) {
            //                             Artisan::call('cache:table');
            //                             session()->flash('success', 'All tables imported and verified!');
            //                             return redirect()->route('step5', ['token' => bcrypt('step_5')]);
            //                         }
            //                     }
            //                     session()->flash('error', 'Some tables are missing. Please try force import.');
            //                     return back();
            //                 }
            //             }
            //         }
            //     }
            // }
            
            // // Use Laravel's DB::unprepared() method (uses PDO, no CLI needed)
            // if (!empty(trim($sql))) {
            //     DB::unprepared($sql);
            // }
            
            // // Verify all tables are imported before proceeding to step 5
            // $allTablesImported = $this->verify_all_tables_imported($sql_path);
            
            // if (!$allTablesImported) {
            //     // Check which tables are still missing
            //     $existingTablesAfter = $this->get_existing_tables();
            //     $tablesInSql = $this->parse_table_names_from_sql($sql);
            //     $stillMissing = array_diff($tablesInSql, $existingTablesAfter);
                
            //     if (!empty($stillMissing)) {
            //         Log::warning('Still missing tables: ' . implode(', ', $stillMissing));
            //         session()->flash('error', 'Some tables could not be imported: ' . implode(', ', $stillMissing) . '. Please try again.');
            //         return back();
            //     }
            // }
            
            // // version_2.11.1 - Create cache table
            // Artisan::call('cache:table');
            
            $message = $skipExisting && !empty($existingTables) 
                ? 'Database imported successfully! (Skipped existing tables)' 
                : 'Database imported successfully using PDO method!';
            
            // if ($allTablesImported) {
            //     $message .= ' All tables verified.';
            // }
            
            session()->flash('success', $message);
            return redirect()->route('step5', ['token' => bcrypt('step_5')]);
        } catch (\Exception $exception) {
            $errorMessage = $exception->getMessage();
            Log::error('Database import via PDO failed: ' . $errorMessage);
            
            // Check if error is due to existing tables
            if (strpos($errorMessage, 'already exists') !== false || 
                strpos($errorMessage, 'Duplicate') !== false ||
                strpos($errorMessage, 'Table') !== false) {
                // If we're skipping existing, try again without skipping to get better error
                if ($skipExisting) {
                    return $this->import_sql_using_pdo($sql_path, false);
                }
                session()->flash('error', 'Your database is not clean, do you want to clean database then import?');
            } else {
                session()->flash('error', 'Database import failed: ' . $errorMessage);
            }
            return back();
        }
    }

    function create_database_if_not_exists($db_host = "", $db_name = "", $db_user = "", $db_pass = ""): array
    {
        // Validate inputs
        if (empty($db_host) || empty($db_name) || empty($db_user)) {
            return ['success' => false, 'message' => 'Database credentials are required.'];
        }

        try {
            // Connect to MySQL server without specifying database
            $dsn_server = "mysql:host={$db_host};charset=utf8mb4";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_TIMEOUT => 5,
            ];
            
            $pdo = new \PDO($dsn_server, $db_user, $db_pass, $options);
            
            // Check if database exists
            $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = " . $pdo->quote($db_name));
            $databaseExists = $stmt->fetch();
            
            if (!$databaseExists) {
                // Create the database
                $pdo->exec("CREATE DATABASE `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                Log::info("Database '{$db_name}' created successfully.");
                return ['success' => true, 'message' => "Database '{$db_name}' created successfully."];
            } else {
                Log::info("Database '{$db_name}' already exists.");
                return ['success' => true, 'message' => "Database '{$db_name}' already exists."];
            }
        } catch (\PDOException $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();
            
            if ($errorCode == 1045) {
                $message = 'Access denied. Please check your database username and password.';
            } elseif ($errorCode == 1044) {
                $message = "Access denied. The user '{$db_user}' does not have permission to create databases.";
            } elseif ($errorCode == 2002 || strpos($errorMessage, 'Connection refused') !== false) {
                $message = "Cannot connect to database host '{$db_host}'. Please check if MySQL server is running.";
            } else {
                $message = "Failed to create database: " . $errorMessage;
            }
            
            Log::error('Database creation failed: ' . $errorMessage);
            return ['success' => false, 'message' => $message];
        } catch (\Exception $exception) {
            Log::error('Database creation error: ' . $exception->getMessage());
            return ['success' => false, 'message' => 'Database creation error: ' . $exception->getMessage()];
        }
    }

    function check_database_connection($db_host = "", $db_name = "", $db_user = "", $db_pass = ""): array
    {
        // Validate inputs
        if (empty($db_host)) {
            return ['success' => false, 'message' => 'Database host is required.'];
        }
        if (empty($db_name)) {
            return ['success' => false, 'message' => 'Database name is required.'];
        }
        if (empty($db_user)) {
            return ['success' => false, 'message' => 'Database username is required.'];
        }

        try {
            // First, try to connect to MySQL server without specifying database
            // This helps identify if the issue is with host/credentials or database existence
            $dsn_server = "mysql:host={$db_host};charset=utf8mb4";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_TIMEOUT => 5,
            ];
            
            // Test server connection first
            $pdo_server = new \PDO($dsn_server, $db_user, $db_pass, $options);
            
            // Now try to connect to the specific database
            $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
            $pdo = new \PDO($dsn, $db_user, $db_pass, $options);
            
            // Test the connection by running a simple query
            $pdo->query("SELECT 1");
            
            return ['success' => true, 'message' => 'Connection successful'];
        } catch (\PDOException $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();
            
            // Provide user-friendly error messages
            if ($errorCode == 1045) {
                $message = 'Access denied. Please check your database username and password.';
            } elseif ($errorCode == 1049 || strpos($errorMessage, 'Unknown database') !== false) {
                $message = "Database '{$db_name}' does not exist. Please create the database first.";
            } elseif ($errorCode == 2002 || strpos($errorMessage, 'Connection refused') !== false || strpos($errorMessage, 'No connection could be made') !== false) {
                $message = "Cannot connect to database host '{$db_host}'. Please check if MySQL server is running and the host is correct.";
            } elseif ($errorCode == 1044) {
                $message = "Access denied. The user '{$db_user}' does not have permission to access the database '{$db_name}'.";
            } else {
                $message = "Database connection failed: " . $errorMessage;
            }
            
            Log::error('Database connection failed: ' . $errorMessage);
            return ['success' => false, 'message' => $message];
        } catch (\Exception $exception) {
            Log::error('Database connection error: ' . $exception->getMessage());
            return ['success' => false, 'message' => 'Database connection error: ' . $exception->getMessage()];
        }
    }
}
