import vcCake from 'vc-cake'
import SaveButtonControl from './lib/navbar-save-button'
import '../../../../sources/less/ui/loader/init.less'

vcCake.add('ui-node-save', (api) => {
  api.module('ui-navbar').do('addElement', 'Save post', SaveButtonControl, { pin: 'visible' })
})
