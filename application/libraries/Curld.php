<?php

Class Curld {

	public function download ($data, $simultaneous = 1, $save_to)
	{
		$loops = array_chunk($data, $simultaneous, true);

		foreach ($loops as $key => $value)
		{
			foreach ($value as $urlkey => $urlvalue)
			{
				$ch[$urlkey] = curl_init($urlvalue["url"]);
				curl_setopt($ch[$urlkey], CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch[$urlkey], CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch[$urlkey], CURLOPT_SSL_VERIFYHOST, false);

				curl_setopt($ch[$urlkey], CURLOPT_CONNECTTIMEOUT, 0);
				curl_setopt($ch[$urlkey], CURLOPT_TIMEOUT, 0);
			}

			$mh = curl_multi_init();

			foreach ($value as $urlkey => $urlvalue)
			{
				curl_multi_add_handle($mh, $ch[$urlkey]);
			}

			$running = null;
			do {
				$status = curl_multi_exec($mh, $running);
				if ($running){
					curl_multi_select($mh);
				}
			} while ($running && $status == CURLM_OK);

			foreach ($value as $urlkey => $urlvalue)
			{
				$response = curl_multi_getcontent($ch[$urlkey]);
				file_put_contents($save_to.$urlvalue["saveas"], $response);
				curl_multi_remove_handle($mh,$ch[$urlkey]);
				curl_close($ch[$urlkey]);
			}

		}
	}
}

?>