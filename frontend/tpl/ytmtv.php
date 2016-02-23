<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House. 
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/

?>

<div id="ytmtvplayer">
    Loading show... Please wait.
</div>

<script type="text/javascript">
    var ytMtvOptions = <?php echo json_encode($options); ?>;
    var ajaxUrl = '<?php echo admin_url( "admin-ajax.php" ) ?>';
    var ytFirstVideoID = '<?php echo $ytFirstVideoId; ?>';
</script>