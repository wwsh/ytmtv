<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House. 
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/
?>

<h1>YT MTV Options</h1>

<form novalidate="novalidate" action="" method="post">
    <input type="hidden" value="update" name="action">
    <table class="form-table">
        <tbody>
        <?php foreach ($options as $option => $value): ?>
    <tr>
        <th scope="row"><label for="<?php echo $option; ?>"><?php echo ucfirst($option); ?></label></th>
        <td>
            <input type="text" class="regular-text" value="<?php echo $value; ?>" id="<?php echo $option; ?>"
                   name="<?php echo $option; ?>">
            <?php if (isset($hints[$option])): ?>
                <p id="<?php echo $option; ?>-description"
                   class="description"><?php echo $hints[$option]; ?></p>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>

</tbody>
</table>


<p class="submit"><input type="submit" value="Save" class="button button-primary" id="submit" name="submit">
</p></form>

<hr/>
<h2>Usage</h2>
<p>Place your shortcode everywhere on this planet and get the ball rollin'!</p>
<p>Syntax is: [ytmtv]</p>