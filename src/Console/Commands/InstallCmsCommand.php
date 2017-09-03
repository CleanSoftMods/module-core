<?php namespace CleanSoft\Modules\Core\Console\Commands;

use CleanSoft\Modules\Core\Models\Role;
use CleanSoft\Modules\Core\ModulesManagement\Repositories\Contracts\CoreModulesRepositoryContract;
use CleanSoft\Modules\Core\ModulesManagement\Repositories\CoreModulesRepository;
use CleanSoft\Modules\Core\Providers\InstallModuleServiceProvider;
use CleanSoft\Modules\Core\Repositories\Contracts\RoleRepositoryContract;
use CleanSoft\Modules\Core\Repositories\RoleRepository;
use CleanSoft\Modules\Core\Users\Repositories\Contracts\UserRepositoryContract;
use CleanSoft\Modules\Core\Users\Repositories\UserRepository;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install WebEd';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var array
     */
    protected $container = [];

    /**
     * @var array
     */
    protected $dbInfo = [];

    /**
     * @var Role
     */
    protected $role;

    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    /**
     * @var CoreModulesRepository
     */
    protected $coreModulesRepository;

    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        Filesystem $filesystem,
        CoreModulesRepositoryContract $coreModulesRepository,
        RoleRepositoryContract $roleRepository,
        UserRepositoryContract $userRepository
    )
    {
        parent::__construct();
        $this->files = $filesystem;
        $this->app = app();
        $this->coreModulesRepository = $coreModulesRepository;
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->createEnv();
        $this->getDatabaseInformation();
        /**
         * Migrate tables
         */
        $this->line('Migrate database...');
        $this->app->register(InstallModuleServiceProvider::class);
        $this->line('Create super admin role...');
        $this->createSuperAdminRole();
        $this->line('Create admin user...');
        $this->createAdminUser();
        $this->line('Install module dependencies...');
        $this->registerInstallModuleService();
        session()->flush();
        session()->regenerate();
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        $this->info("\nWebEd installed. Current version is " . get_cms_version());
    }

    /**
     * Get database information
     */
    protected function getDatabaseInformation()
    {
        $this->dbInfo['connection'] = env('DB_CONNECTION');
        $this->dbInfo['host'] = env('DB_HOST');
        $this->dbInfo['database'] = env('DB_DATABASE');
        $this->dbInfo['username'] = env('DB_USERNAME');
        $this->dbInfo['password'] = env('DB_PASSWORD');
        $this->dbInfo['port'] = env('DB_PORT');
        if (!check_db_connection()) {
            $this->error('Please setup your database information first!');
            die();
        }
        $this->info('Database OK...');
    }

    protected function createSuperAdminRole()
    {
        $role = $this->roleRepository->findWhere([
            'slug' => 'super-admin',
        ]);
        if ($role) {
            $this->role = $role;
            $this->info('Admin role already exists...');
            return;
        }
        try {
            $this->role = $this->roleRepository->find($this->roleRepository->create([
                'name' => 'Super Admin',
                'slug' => 'super-admin',
            ]));
            $this->info('Admin role created successfully...');
        } catch (\Exception $exception) {
            $this->error('Error occurred when create role...');
        }
    }

    protected function createAdminUser()
    {
        try {
            $user = $this->userRepository->find($this->userRepository->create([
                'username' => $this->ask('Your username', 'admin'),
                'email' => $this->ask('Your email', 'admin@webed.com'),
                'password' => $this->secret('Your password'),
                'display_name' => $this->ask('Your display name', 'Super Admin'),
                'first_name' => $this->ask('Your first name', 'Admin'),
                'last_name' => $this->ask('Your last name', false),
            ]));
            if ($this->role) {
                $this->role->users()->save($user);
            }
            $this->info('User created successfully...');
        } catch (\Exception $exception) {
            $this->error('Error occurred when create user...');
        }
    }

    protected function registerInstallModuleService()
    {
        $data = [
            'alias' => 'webed-core',
        ];
        $cmsVersion = get_cms_version();
        $baseCore = $this->coreModulesRepository->findWhere($data);
        if (!$baseCore) {
            $this->coreModulesRepository->create(array_merge($data, [
                'installed_version' => $cmsVersion,
            ]));
        } else {
            $this->coreModulesRepository->update($baseCore, [
                'installed_version' => get_cms_version(),
            ]);
        }
        $modules = get_core_module()->where('namespace', '!=', 'CleanSoft\Modules\Core');
        $corePackages = get_composer_modules();
        foreach ($modules as $module) {
            $namespace = str_replace('\\\\', '\\', $module['namespace'] . '\Providers\InstallModuleServiceProvider');
            if (class_exists($namespace)) {
                $this->app->register($namespace);
            }
            $currentPackage = $corePackages->where('name', '=', $module['repos'])->first();
            $data = [
                'alias' => $module['alias'],
            ];
            if ($currentPackage) {
                $data['installed_version'] = isset($module['version']) ? $module['version'] : $currentPackage['version'];
            }
            $coreModule = $this->coreModulesRepository->findWhere([
                'alias' => $module['alias'],
            ]);
            $this->coreModulesRepository->createOrUpdate($coreModule, $data);
        }
        \Artisan::call('vendor:publish', [
            '--tag' => 'webed-public-assets',
            '--force' => true,
        ]);
        \Artisan::call('cache:clear');
    }

    /**
     * @return string
     */
    protected function createEnv()
    {
        $env = $this->files->exists('.env') ? $this->files->get('.env') : $this->files->get('.env.example') ?: '';
        $this->files->put('.env', $env);
        return $env;
    }
}
