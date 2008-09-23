<?php
class ezcMvcExternalRedirect //implements ezcMvcStatus
{
	public function __construct( $location )
	{
		$this->location = $location;
	}
}
?>
