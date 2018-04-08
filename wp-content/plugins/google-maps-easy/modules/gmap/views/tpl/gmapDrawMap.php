<?php
$popup = $this->currentMap['params']['map_display_mode'] == 'popup' ? true : false;

$viewId = $this->currentMap['view_id'];
$mapHtmlId = $this->currentMap['view_html_id'];
$mapPreviewClassname = @$this->currentMap['html_options']['classname'];
$mapOptsClassname = $popup ? 'display_as_popup' : '';
?>
<?php if($popup){ ?>
	<div class="map-preview-img-container">
		<img src="<?php echo GMP_IMG_PATH . 'gmap_preview.png'?>" class="show_map_icon map_num_<?php echo $this->currentMap['id']; ?>"
			 data-map_id="<?php echo $this->currentMap['id']; ?>" title = "Click to view map" alt="Map Widget" style="display: none;">
	</div>
	<div id="gmpWidgetMapPopupWnd">
<?php } ?>
		<div class="gmp_map_opts <?php echo $mapOptsClassname;?>" id="mapConElem_<?php echo $viewId;?>"
			data-id="<?php echo $this->currentMap['id']; ?>" data-view-id="<?php echo $viewId;?>"
			>
			<div class="gmpMapDetailsContainer" id="gmpMapDetailsContainer_<?php echo $viewId ;?>">
				<div class="gmp_MapPreview <?php echo $mapPreviewClassname;?>" id="<?php echo $mapHtmlId ;?>"></div>
			</div>
			<div class="gmpMapProControlsCon" id="gmpMapProControlsCon_<?php echo $viewId;?>">
				<?php dispatcherGmp::doAction('addMapBottomControls', $this->currentMap); ?>
			</div>
			<div class="gmpMapProDirectionsCon" id="gmpMapProDirectionsCon_<?php echo $viewId;?>" >
				<?php dispatcherGmp::doAction('addMapDirectionsData', $this->currentMap); ?>
			</div>
			<div class="gmpMapProKmlFilterCon" id="gmpMapProKmlFilterCon_<?php echo $viewId;?>" >
				<?php dispatcherGmp::doAction('addMapKmlFilterData', $this->currentMap); ?>
			</div>
		</div>
<?php if($popup){ ?>
	</div>
<?php } ?>