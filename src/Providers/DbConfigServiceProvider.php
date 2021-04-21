<?php

namespace Tadcms\Backend\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Tadcms\System\Models\Config as DataConfig;

class DbConfigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->checkDbConnection()) {
            return;
        }
        
        $mail = DataConfig::getConfigEmail();

        if ($mail['email_setting']) {
            $config = [
                'driver'     => 'smtp',
                'host'       => $mail['email_host'],
                'port'       => (int) $mail['email_port'],
                'from'       => [
                    'address'   => $mail['email_from_address'],
                    'name'      => $mail['email_from_name']
                ],
                'encryption' => $mail['email_encryption'],
                'username'   => $mail['email_username'],
                'password'   => $mail['email_password'],
            ];

            Config::set('mail', $config);
        }
    }
    
    protected function checkDbConnection()
    {

        try {
            DB::connection()->getPdo();

            if (Schema::hasTable('configs')) {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    
        return false;
    }
}
