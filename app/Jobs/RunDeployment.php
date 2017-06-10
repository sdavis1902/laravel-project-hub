<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Yaml\Yaml;
use App\Models\Deployment;
use PusherHelper;

class RunDeployment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $tries = 1;
	protected $deployment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Deployment $deployment)
    {
        $this->deployment = $deployment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		echo "Starting Deployment\n";
		$this->deployment->status = 'Active';
		$this->deployment->save();

		// the config to be converted to yaml and saved to temp file
		$slug = str_slug($this->deployment->stage->project->name.' '.$this->deployment->stage->name.' '.$this->deployment->id, '-');
		$config = [
			$slug => [
				'hostname' => $this->deployment->stage->host,
				'user'     => $this->deployment->stage->host_user,
				'multiplexing' => false,
				'repository'   => $this->deployment->stage->project->repository,
				'stage'        => $slug,
				'deploy_path'  => $this->deployment->stage->deploy_path
			]
		];
		if($this->deployment->stage->host_become) $config[$slug]['become'] = $this->deployment->stage->host_become;

		$yaml = Yaml::dump($config);

		$filename = sys_get_temp_dir() . '/' . $slug . '.yml';
		file_put_contents($filename, $yaml);

		$process = new Process('php vendor/bin/dep deploy ' . $slug .' -vvv --mystage='. $slug);
		$process->setWorkingDirectory('/var/www/html/sdhub');
		$process->run(function ($type, $buffer) {
			$message = nl2br($buffer);

			$this->deployment->logs.= $message;
			$this->deployment->save();

			PusherHelper::trigger('deployment', 'more_log', [
				'message' => $message
			]);
		});

		$this->deployment->status = $process->isSuccessful() ? 'Complete' : 'Failed';
		$this->deployment->save();
    }
}
