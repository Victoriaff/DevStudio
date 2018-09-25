
<div id="dev-studio" class="dev-studio">

	<div class="header">
		<div class="logo">
			<img src="<?php echo DevStudio()->get_plugin_url(); ?>/assets/images/logo.png">
            <div class="on-off <?php echo DevStudio()->enabled ? 'on':'off'; ?>">
                <div class="slider"></div>
                <div class="items">On&nbsp;&nbsp;&nbsp;Off</div>

            </div>
		</div>
		<div class="modules">
			<?php
            echo $data['a'];
            $active_module = 'wordpress';
			foreach(DevStudio()->modules() as $module_name=>$module) {
			    ?>
                <div class="tab-module<?php echo ($module_name == $active_module ? ' active':''); ?>" data-module="<?php echo esc_attr($module_name); ?>"><?php echo $module->title;?></div>
			<?php } ?>
		</div>
		<div class="buttons">
            <button id="dev-studio-save"><?php echo __('Save', 'dev-sudio'); ?></button>
		</div>
	</div>

	<div class="workspace">
		<div class="tabs-components">
			<?php
			//foreach( DevStudio()->map[$active_module]

			//dump( DevStudio()->components() );

			//foreach(DevStudio()->checkpoints() as $checkpoint=>$data) {
			//	echo '<option value="'.$checkpoint.'">'.$checkpoint.'</option>';
			//}
			?>
		</div>
		<div class="tabs-data">

			<div class="tabs">
				<div class="checkpoints">
                    <div class="title"><?php echo __('Checkpoints', 'dev-studio'); ?>&nbsp;</div>
					<div class="select">

                        <?php
                        //dump( DevStudio()->checkpoints() );
                        
                        ?>
						<select id="checkpoint">
						<?php
						foreach(DevStudio()->checkpoints() as $checkpoint=>$data) {
							echo '<option value="'.$checkpoint.'">'.$checkpoint.'</option>';
						}
						?>

						</select>
					</div>
                    <div class="icons">
                        <i class="fb fb-redo"></i><i class="fb fb-cog"></i>
                    </div>
				</div>
				<div class="tabs-units">
                    <div class="unit" data-unit="overview">Overview</div>

				</div>
			</div>

			<div class="data">
                <div id="dev-studio-data"></div>
                <div id="dev-studio-data-detail"></div>
            </div>
		</div>

	</div>


</div>
