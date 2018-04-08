/* jshint esnext:true */

var toggle = ( el, visibility ) => {
	'use strict';

	if ( +visibility ) {
		el.show();
	} else {
		el.hide();
	}
};

export { toggle };