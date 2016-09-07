<?php 
namespace Cooglemirror\Smappee;

use Illuminate\Support\ServiceProvider;
use Coogle\Smappee;
use Symfony\Component\Console\Command\Command;

class SmappeeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cooglemirror/smappee', 'cooglemirror-smappee');
		
		\App::bind('cooglemirror-smappee.commands.poll-smappee', function($app) {
		    return new PollSmappeeCommand(); 
		});
		
		$this->commands([
		   'cooglemirror-smappee.commands.poll-smappee'    
		]);
		
		\Event::listen('cooglemirror.render', function($layoutView) {
		    \View::composer('cooglemirror-smappee::widget', '\Cooglemirror\Smappee\Widget');
		    
		    $view = \View::make('cooglemirror-smappee::widget')->render();
		    $layoutView->with(\Config::get('cooglemirror-smappee::widget.placement'), $view);
		});
		
		if(\DB::getDriverName() == 'sqlite') {
		    $path = \DB::getConfig('database');
		    
		    if(!file_exists($path) && is_dir(dirname($path))) {
		        touch($path);
		    }
		}
		
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
