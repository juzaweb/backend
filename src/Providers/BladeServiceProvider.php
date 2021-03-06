<?php

namespace Tadcms\Backend\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * @package    tadcms\tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 */
class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Add a directive in Blade admin_header
         */
        Blade::directive('admin_header', function () {
            return "<?php admin_header(); ?>";
        });
    
        /*
         * Add a directive in Blade admin_footer
         */
        Blade::directive('admin_footer', function () {
            return "<?php admin_footer(); ?>";
        });
        
    }
}
