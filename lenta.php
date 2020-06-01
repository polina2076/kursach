<?php
	require_once"header.php";
	require_once"connection.php";
	
	$query = mysqli_query($db,"SELECT * FROM news ORDER BY date desc");
?>
<div id="content">
	<section id="cd-timeline" class="cd-container">
		<? while($array_news = mysqli_fetch_array($query)){?>
			<div class="cd-timeline-block">
				<div class="cd-timeline-img cd-picture">
					<img src="images/cd-icon-picture.svg" alt="Picture">
				</div>
				<div class="cd-timeline-content">
					<h2><? echo $array_news['name']; ?></h2>
					<p><? echo $array_news['value']; ?></p>
					<img src="<? echo $array_news['img']; ?>" style="width:40%; object-fit: cover">
					<span class="cd-date"><? echo $array_news['date']; ?></span>
				</div> 
			</div> 
		<?}?>	
	</section> 
</div>
<?php
	require_once"footer.php";
?>