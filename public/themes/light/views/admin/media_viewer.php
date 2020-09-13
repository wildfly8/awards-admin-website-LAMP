<?php
defined('VONZO') OR exit();

$xMedia = $data['media'];
?>

<div class="section">

	<h6>Media #<?php echo $xMedia['id']; ?></h6>
	<h4 class="page-title-bold mb-3 mt-0"><?php echo $xMedia['title']; ?></h4>

			<p>
				<?php
				if ($xMedia['legacy'] == 1) {
					$url = 'http://www.awardsawardsawards.com/assets/artifact/'.$xMedia['file_path'];
				} else {
					$url = URL_PATH . '/uploads/' . $xMedia['file_path'];
				}
				switch ($xMedia['type'])
				{
					case "Image":
						$thumbnail = '<img src="'.$url.'" height=600>';
						break;
					case "Document":
						$thumbnail = '<a href="'.$url.'" data-nd target="_blank">View</a>';
						break;
				}
				echo $thumbnail;
				?>
			</p>

			<h2><?php echo $xMedia['main_content']; ?></h2>

			<p><?php echo $xMedia['source']; ?></p>

			<h5>Connections</h5>

			<p><B>People:</B> <br>
			<?php echo $data['people']; ?>
      </p>

			<p><B>Projects:</B> <br>
			<?php echo $data['projects']; ?>
      </p>

			<p><B>Studios: </B><br>
			<?php echo $data['studios']; ?>
      </p>

			<p><B>Vendors: </B><br>
			<?php echo $data['vendors']; ?>
      </p>

			<p><B>Products:</B> <br>
			<?php echo $data['products']; ?>
      </p>


</div>
