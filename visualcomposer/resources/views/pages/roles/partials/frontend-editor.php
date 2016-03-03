<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use VisualComposer\Helpers\Generic\Templates;

if ( app('FrontendEditor')->inlineEnabled() ) {
	Templates::render( 'pages/roles/partials/part', [
		'part' => $part,
		'role' => $role,
		'paramsPrefix' => 'vc_roles[' . $role . '][' . $part . ']',
		'controller' => app( 'RoleAccess' )->who( $role )->part( $part ),
		'customValue' => 'custom',
		'options' => [
			[ true, __( 'Enabled', 'vc5' ) ],
			[ true, __( 'Disabled', 'vc5' ) ],
		],
		'mainLabel' => __( 'Frontend editor', 'vc5' ),
		'customLabel' => __( 'Frontend editor', 'vc5' ),
	] );
}

