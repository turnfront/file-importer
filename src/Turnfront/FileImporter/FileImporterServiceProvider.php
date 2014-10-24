<?php namespace Turnfront\FileImporter;

use Illuminate\Support\ServiceProvider;

class FileImporterServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
    \App::bind("Turnfront\\FileImporter\\Contracts\\FileImporterInterface", function ($app, $params){
      $params['filePath'] = !empty($params['filePath']) ? $params['filePath'] : null;
      $params['hasHeader'] = !empty($params['hasHeader']) ? $params['hasHeader'] : false;
      $params['length'] = isset($params['length']) ? $params['length'] : 1000;
      $params['delimiter'] = !empty($params['delimiter']) ? $params['delimiter'] : null;
      return new Services\FileImporter($params['filePath'], $params['hasHeader'], $params['length'], $params['delimiter']);
    });
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