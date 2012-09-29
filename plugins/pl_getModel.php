<?php class pl_getModel {

function engine(&$q) {
	if (!$q->ajax) {
		if ($q->base->fn($q,"models")) {
			$q->html=$q->fn_models->loadModel($q,'alpha');
		}
	}
}

} ?>
