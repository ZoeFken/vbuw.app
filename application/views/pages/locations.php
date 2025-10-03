<?php
	// echo '<pre>';
	// var_dump($locations); 
	// echo '</pre>';
?>
<h2 class="display-4 text-center pb-3"><?php echo $this->lang->line('titel'); ?></h2>


<?php foreach($locations as $location): ?>
<?php $first_key = key($location); ?>
<button type="button" class="collapsible"><?php echo $first_key ?></button>
<div class="content">
	<ul class="coord_locations">
		<?php foreach($location as $locationGroup): ?>
			<?php foreach($locationGroup as $point): ?>
				<?php $name = $point['name'];
				$coordinate = $point['Point']['coordinates'];
				$coordinates = explode(",", $coordinate);
				$longitude = $coordinates[1];
				$latitude = $coordinates[0];
				$baseUrl = "https://waze.com/ul?ll=";
				$link = $baseUrl . $longitude . "," . $latitude . "&navigate=yes";
				?>
				<li class="coord_location"><a href="<?php echo $link ?>" target="_blank"><?php echo $name ?></a></li>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</ul>
</div>

<?php endforeach; ?>

<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>
