<?php
function hashit($fname){
	return hash('sha256', $fname);
}
?>