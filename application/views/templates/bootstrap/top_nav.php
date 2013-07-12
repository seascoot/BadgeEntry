<div id="top-nav" class="navbar .navbar-static-top">
	<div class="navbar-inner">
	    <div class="container">
	
	        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
	        </a> 
	        
	        <a class="brand" href="<?=site_url('home/index');?>">{site_title}</a>
	        
	        <!-- Everything you want hidden at 940px or less, place within here -->
	        <div class="nav-collapse collapse">
	            <ul class="nav">
					<?php if(isset($this->conf->option['config_level']) && $this->conf->option['config_level'] >= 2): ?>
							<li class="<?php echo ($this->uri->segment(1)=='people')? 'active' : ''; ?>"><?=anchor('people', 'People')?></li>
							<li class="<?php echo ($this->uri->segment(1)=='meetings')? 'active' : ''; ?>"><?=anchor('meetings', 'Meetings')?></li>
							<li class="<?php echo ($this->uri->segment(1)=='attendance')? 'active' : ''; ?>"><?=anchor('attendance', "Attendance")?></li>
							<li class="<?php echo ($this->uri->segment(1)=='reports')? 'active' : ''; ?>"><?=anchor('reports', 'Reports')?></li>
							<li class="<?php echo ($this->uri->segment(1)=='doc')? 'active' : ''; ?>"><a href="<?=base_url('doc/badgeentry/about.html')?>">About BadgeEntry</a></li>
					<?php endif; ?>
	                <!-- <li class="active"><a href="<?=site_url('home/index');?>">Home</a></li> -->
	            </ul>
	        </div>
	        <!--/nav-collapse-->
	    </div>
    </div>
</div>