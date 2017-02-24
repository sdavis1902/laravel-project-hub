<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Lunanode;

class BackupVirtualMachines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lunanode:backup-virtual-machines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup Virtual Machines on LN';

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
    public function handle()
    {

        $vms = Lunanode::request('vm', 'list');

		$vmimages = [];

		foreach($vms as $vm){
			if( !isset( $vmimages[$vm->name] ) ) $vmimages[$vm->name] = [];
			$name = date('M j Y').' '.$vm->name;
			$this->info("Creating new snapshot $name");
			Lunanode::request('vm', 'snapshot', [
				'vm_id' => $vm->vm_id,
				'name'  => $name
			]);
		}
		$this->info('backups complete');

		$this->info('removing old images');
		$images = Lunanode::request('image', 'list');

		foreach($images as $image){
			foreach($vms as $vm){
				if( preg_match('/'.$vm->name.'/', $image->name) ){
					$vmimages[$vm->name][strtotime(str_replace($vm->name, '', $image->name))] = $image;
					break;
				}
			}
		}

		foreach($vmimages as $images){
			if( count($images) <=2 ) continue;
			// sort by newest images to oldest
			krsort($images);
			// remove the first two images since we want to keep them
			array_shift($images);
			array_shift($images);

			// loop and remove all older images
			foreach( $images as $image ){
				$this->info("Removing image ".$image->name);
				Lunanode::request('image', 'delete', [
					'image_id' => $image->image_id
				]);
			}
		}
		$this->info('done removing old images');
		$this->info('done backing up vms and removing old images');
    }
}
