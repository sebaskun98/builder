/*eslint jsx-quotes: [2, "prefer-double"]*/
var vcCake = require('vc-cake')
vcCake.add('ui-brand-logo', function (api) {
  var React = require('react')
  var Control = React.createClass({
    render: function () {
      return <a className="vc-ui-navbar-logo" title="Visual Composer"
        href="http://alpha.visualcomposer.io/wp-admin/?amputm_medium=frontend_editor"
        target="_blank">
        <span className="vc-ui-navbar-logo-title">Visual Composer</span>
      </a>
    }
  })
  api.module('ui-navbar').do('addElement', 'Get link', Control, 'header')
})
