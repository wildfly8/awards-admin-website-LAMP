<?php
defined('VONZO') OR exit();
?>
<div id="header" class="inside-header">
	<a href="<?php echo $data['url']; ?>">
		<div class="header-logo-text"><?php echo SITE_NAME; ?></div>
	</a>
	<?php /*
	<a href="<?php echo $data['url']; ?>/admin/add/nomination" class="top-bar-right-button">
		Add Nomination
	</div>
	*/ ?>
</div>


<div id="sidebar" class="sidebar inside-sidebar">
  <ul class="nav">
    <li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "dashboard"){ echo "active"; } ?>">
      <a href="<?php echo $data['url']; ?>/admin/dashboard">
				<p class="left-nav-title">Dashboard</p>
      </a>
    </li>
		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "shows"){ echo "active"; } ?>">
      <a href="<?php echo $data['url']; ?>/admin/shows">
				<p class="left-nav-title">Award Shows</p>
      </a>
    </li>
		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "people"){ echo "active"; } ?>">
      <a href="<?php echo $data['url']; ?>/admin/people">
				<p class="left-nav-title">People</p>
      </a>
    </li>
		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "projects"){ echo "active"; } ?>">
      <a href="<?php echo $data['url']; ?>/admin/projects">
				<p class="left-nav-title">Projects</p>
      </a>
    </li>
		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "vendors"){ echo "active"; } ?>">
      <a href="<?php echo $data['url']; ?>/admin/vendors">
				<p class="left-nav-title">Vendors</p>
      </a>
    </li>
		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "studios"){ echo "active"; } ?>">
      <a href="<?php echo $data['url']; ?>/admin/studios">
				<p class="left-nav-title">Studios</p>
      </a>
    </li>
		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "products"){ echo "active"; } ?>">
      <a href="<?php echo $data['url']; ?>/admin/products">
				<p class="left-nav-title">Products</p>
      </a>
    </li>
		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "networks"){ echo "active"; } ?>">
      <a href="<?php echo $data['url']; ?>/admin/networks">
				<p class="left-nav-title">Networks</p>
      </a>
    </li>
		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "departments"){ echo "active"; } ?>">
      <a href="<?php echo $data['url']; ?>/admin/departments">
				<p class="left-nav-title">Departments</p>
      </a>
    </li>
		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "media"){ echo "active"; } ?>">
      <a href="<?php echo $data['url']; ?>/admin/media">
				<p class="left-nav-title">Media</p>
      </a>
    </li>
		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "songs"){ echo "active"; } ?>">
      <a href="<?php echo $data['url']; ?>/admin/songs">
				<p class="left-nav-title">Songs</p>
      </a>
    </li>

		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "settings"){ echo "active"; } ?>">
			<a href="<?php echo $data['url']; ?>/settings">
				<p class="left-nav-title">Settings</p>
			</a>
		</li>
		<li class="sidebarList nav-hover <?php if (isset($this->url[1]) && $this->url[1] == "change_password"){ echo "active"; } ?>">
			<a href="<?php echo $data['url']; ?>/change-password">
				<p class="left-nav-title">Change Password</p>
			</a>
		</li>
		<li class="sidebarList nav-hover">
			<a href="<?php echo $data['url']; ?>/logout">
				<p class="left-nav-title">Logout</p>
			</a>
		</li>
  </ul>
</div>

<?=$this->token()?>

<div id="content" class="inside-content">
