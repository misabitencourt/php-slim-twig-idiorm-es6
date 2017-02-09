import moment from 'moment'
import arr from './polyfills/array'
import confirmDialog from './dialogs/confirm'

window.moment = moment
window.dialogs = {
    confirm: confirmDialog
}

document.body.addEventListener('click', (e) => {
    if (e.target && e.target.dataset.linkConfirm) {
        confirmDialog('Confirme', e.target.dataset.linkConfirm).then((res) => {
            if (res) {
                window.location = e.target.dataset.link
            }
        })
    }
})

console.log('Javscript goes here!!')
