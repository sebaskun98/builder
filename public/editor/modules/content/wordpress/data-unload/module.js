import vcCake from 'vc-cake'
import $ from 'jquery'

vcCake.add('content-wordpress-data-unload', (api) => {
  let initialStart = true
  const unload = {
    setDataChanged: () => {
      if (initialStart) {
        initialStart = false
        return
      }
      $(window).on('beforeunload.vcv-save', (e) => {
        return 'Are you sure to leave? All unsaved data will be changed?'
      })
    },
    unsetDataChanged: () => {
      $(window).off('beforeunload.vcv-save')
    }
  }
  api.reply('data:changed', unload.setDataChanged)
  api.reply('wordpress:data:saved', unload.unsetDataChanged)
})
