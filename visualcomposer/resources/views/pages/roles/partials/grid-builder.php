<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use VisualComposer\Helpers\Generic\Templates;

Templates::render( 'pages/roles/partials/part', [
	'part' => $part,
	'role' => $role,
	'paramsPrefix' => 'vc_roles[' . $role . '][' . $part . ']',
	'controller' => app( 'RoleAccess' )->who( $role )->part( $part ),
	'options' => [
		[ true, __( 'Enabled', 'vc5' ) ],
		[ true, __( 'Disabled', 'vc5' ) ],
	],
	'mainLabel' => __( 'Grid Builder', 'vc5' ),
	'customLabel' => __( 'Grid Builder', 'vc5' ),
	'description' => __( 'Control user access to Grid Builder and Grid Builder Elements.', 'vc5' ),
] );