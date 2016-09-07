<?php

namespace Cooglemirror\Smappee;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Coogle\Smappee;

class PollSmappeeCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cooglemirror-smappee:poll-smappee';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Poll Smappee for new power data';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$smappeeClient = new Smappee(\Config::get('cooglemirror-smappee::widget.smappee.client_id'), 
		                             \Config::get('cooglemirror-smappee::widget.smappee.client_secret'),
		                             \Config::get('cooglemirror-smappee::widget.smappee.username'),
		                             \Config::get('cooglemirror-smappee::widget.smappee.password'));
		
		
		$this->info("Getting Location Information...");
		
		$locations = $smappeeClient->authenticate()
		                           ->getServiceLocations();
		
		
		$this->info("Getting Consumption Data...");
		
		$consumptionData = $smappeeClient->getConsumptionNow($locations[0]['serviceLocationId']);
		
		foreach($consumptionData as $dataPoint) {
		    $usageRecord = new UsageRecord();
		    
		    $usageRecord->recorded_at = \DateTime::createFromFormat('U', $dataPoint['timestamp']/1000, new \DateTimeZone('UTC'));
		    $usageRecord->consumption = $dataPoint['consumption'];
		    $usageRecord->solar = $dataPoint['solar'];
		    $usageRecord->always_on = $dataPoint['alwaysOn'];
		    $usageRecord->save();
		}
		
		$this->info("Downloaded " . count($consumptionData) . " data points from last 5 minutes");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}

