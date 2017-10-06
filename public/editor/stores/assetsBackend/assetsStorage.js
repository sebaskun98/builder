import { addStorage, getService, env } from 'vc-cake'

import CssBuilder from './lib/cssBuilder'
import LibraryManager from './lib/libraryManager'

addStorage('assetsBackend', (storage) => {
  const documentManager = getService('document')
  // const assetsManager = getService('assetsManager')
  const stylesManager = getService('stylesManager')
  const elementAssetsLibrary = getService('elementAssetsLibrary')
  const assetsStorage = getService('modernAssetsStorage')
  const utils = getService('utils')
  const globalAssetsStorage = assetsStorage.getGlobalInstance()
  // const settingsStorage = getStorage('settings')
  const assetsContentWindow = window.document.querySelector('.vcv-layout-iframe').contentWindow
  const assetsWindow = window
  const builder = new CssBuilder(globalAssetsStorage, elementAssetsLibrary, stylesManager, assetsWindow, assetsContentWindow, utils.slugify)
  const libraryStorage = new LibraryManager()
  const data = { elements: {} }

  storage.on('addElement', (id) => {
    let ids = Array.isArray(id) ? id : [ id ]
    ids.forEach((id) => {
      const element = documentManager.get(id)
      data.elements[ id ] = element
      if (env('FEATURE_ASSETS_FILTER') && element.tag === 'row') {
        storage.trigger('addSharedLibrary', element)
      }
      builder.add(element)
    })
  })
  storage.on('updateElement', (id, options) => {
    let ids = Array.isArray(id) ? id : [ id ]
    ids.forEach((id) => {
      const element = documentManager.get(id)
      data.elements[ id ] = element
      if (env('FEATURE_ASSETS_FILTER') && element.tag === 'row') {
        storage.trigger('editSharedLibrary', element)
      }
      builder.update(element, options)
    })
  })
  storage.on('removeElement', (id) => {
    let ids = Array.isArray(id) ? id : [ id ]
    ids.forEach((id) => {
      let tag = data.elements[ id ] ? data.elements[ id ].tag : null
      delete data.elements[ id ]
      builder.destroy(id, tag)
      if (env('FEATURE_ASSETS_FILTER') && tag === 'row') {
        storage.trigger('removeSharedLibrary', id)
      }
    })
  })
  storage.on('resetElements', () => {
    globalAssetsStorage.resetElements(Object.keys(documentManager.all()))
  })
  storage.on('addSharedLibrary', (element) => {
    let id = element.id
    libraryStorage.add(id, element)
  })
  storage.on('editSharedLibrary', (element) => {
    let id = element.id
    libraryStorage.edit(id, element)
  })
  storage.on('removeSharedLibrary', (id) => {
    libraryStorage.remove(id)
  })
  // const updateSettingsCss = () => {
  //   const globalCss = settingsStorage.state('globalCss').get() || ''
  //   const customCss = settingsStorage.state('customCss').get() || ''
  //   builder.buildSettingsCss(globalCss + customCss)
  // }
  // settingsStorage.state('globalCss').onChange(updateSettingsCss)
  // settingsStorage.state('customCss').onChange(updateSettingsCss)
})
