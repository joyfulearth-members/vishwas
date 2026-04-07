<?php
$list = [
	'books' => 'Books',
	'dissertations' => 'Dissertations',
	'documentaries' => 'Documentaries and Social Media',
	'mindfulness' => 'Relevant Articles and Other Sources',
	'peer-support-in-india' => 'Peer Support in India',
];

$onlyCat = variable('show-only');
renderMenu($list);

//#Category	Name	By	Description	Link
if ($onlyCat) renderItems($onlyCat != 'all' ? $list[$onlyCat] : false);

function renderItems($onlyCat) {
	$sheet = getSheet(__DIR__ . '/_resources.tsv', $onlyCat ? 'Category' : false);
	$items = $onlyCat ? $sheet->group[$onlyCat] : $sheet->rows;

	$lastCat = '';
	foreach ($items as $item) {
		$name = trim($item[$sheet->columns['Name']]);
		if (!$name) continue;

		$cat = trim($item[$sheet->columns['Category']]);
		if ($lastCat == '') contentBox('resources-' . $name, 'container mt-5');

		if ($cat != '' && $lastCat != $cat) {
			if ($lastCat != '') { echo '</ol>'; contentBox('end'); contentBox('resources-' . $name, 'container'); }
			echo h2($cat); echo '<ol>' . NEWLINE;
			$lastCat = $cat;
		}

		echo '<li>' . makeLink(replaceSpecialChars($name), $item[$sheet->columns['Link']], false);
		if ($by = $item[$sheet->columns['By']]) echo BRNL . 'By: ' . $by;
		$text = replaceSpecialChars($item[$sheet->columns['Description']]);
		echo BRNL . renderMarkdown($text, ['echo' => false]) . '</li>' . NEWLINES2;
	}

	echo '</ol>';
	contentBox('end');
}

function renderMenu($items) {
	contentBox('resources-list', 'container mt-5 box-like-list after-content');
	h2('Resource Categories @ ' . variable('nodeSiteName'));

	menu('/', [
		'ul-class' => '',
		'files' => $items,
		'this-is-standalone-section' => true,
		'parent-slug' => variable(SAFENODEVAR) . '/resources/',
	]);

	echo HRTAG;
	renderAny(__DIR__ . '/_intro.md');
	contentBox('end');
}
