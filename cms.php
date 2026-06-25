<?php
variables([
	VARLinkToSubnodeHome => BOOLYes,
	VARSectionsHaveFiles => BOOLYes,
	socialBuilder::variableName => socialBuilder::create(socialBuilder::default(false))
		->addLinkedIn('in/imran-ali-namazi/', 'Imran N')
		->getItems(),
]);

function site_before_render() {
	if (!sectionIs('our-books'))
		autosetPageMenu([VARLinkToNodeHome => true, DontOverwriteLogo => true]);
}
