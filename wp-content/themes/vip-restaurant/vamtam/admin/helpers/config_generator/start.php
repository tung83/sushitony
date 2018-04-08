<?php
/**
 * begin section
 */

$id = isset( $slug ) ? $slug : $name;
if ( isset( $sub ) ) {
	$id = "$sub $id";
}
$id = preg_replace( '/[^\w]+/', '-', strtolower( $id ) );

global $vamtam_loaded_config_groups;

?>
<div class="vamtam-config-group" style="<?php if ( $vamtam_loaded_config_groups++ > 0 ) echo 'display:none' ?>" id="<?php echo esc_attr( $id )?>-tab-<?php echo intval( $vamtam_loaded_config_groups - 1 ) ?>">
