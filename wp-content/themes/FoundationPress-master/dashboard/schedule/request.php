
<h2>Request schedule</h2>

<ul>

	<?php foreach($results as $result) { ?>
    
    <li><a><?php echo $result['name']; ?>: <?php echo $result['date']; ?></a></li>
    
    <?php } ?>

</ul>