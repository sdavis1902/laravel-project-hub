<?php
namespace App\Library;

use Pusher;

class PusherHelper {
	public function trigger($channel, $event, $data = []){
		$pusher = new Pusher(env('PUSHER_KEY'), env('PUSHER_SECRET'), env('PUSHER_ID'));
		$pusher->trigger($channel, $event, $data);
	}
}
